<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\activity\components;

use an602\modules\activity\Module;
use Yii;
use yii\base\Exception;
use yii\base\Component;
use yii\helpers\Url;
use yii\db\Expression;
use an602\modules\dashboard\components\actions\DashboardStreamAction;
use an602\modules\content\models\ContentContainer;
use an602\modules\activity\models\MailSummaryForm;
use an602\modules\activity\models\Activity;

/**
 * MailSummary is send to the user with a list of new activities
 *
 * @since 1.2
 * @author Luke
 */
class MailSummary extends Component
{

    /**
     * Intervals
     */
    const INTERVAL_NONE = 0;
    const INTERVAL_HOURLY = 1;
    const INTERVAL_DAILY = 2;
    const INTERVAL_WEEKLY = 3;

    /**
     * @var \an602\modules\user\models\User the user
     */
    public $user;

    /**
     * @var int the interval of this summary
     */
    public $interval;

    /**
     * @var int the maximum number of activities in the e-mail summary
     */
    public $maxActivityCount = 50;

    /**
     * @var string the mail summary layout file for html mails
     */
    public $layout = '@activity/views/mails/mailSummary';

    /**
     * @var string the mail summary layout file for plaintext mails
     */
    public $layoutPlaintext = '@activity/views/mails/plaintext/mailSummary';

    /**
     * Sends the summary mail to the user
     */
    public function send()
    {
        if ($this->user === null || empty($this->user->email)) {
            return false;
        }

        Yii::$app->i18n->setUserLocale($this->user);

        $outputHtml = '';
        $outputPlaintext = '';

        $mailRenderer = new ActivityMailRenderer();
        foreach ($this->getActivities() as $activity) {
            $outputHtml .= $mailRenderer->render($activity);
            $outputPlaintext .= $mailRenderer->renderText($activity);
        }

        if (empty($outputHtml)) {
            return false;
        }

        try {
            Yii::$app->view->params['showUnsubscribe'] = true;
            Yii::$app->view->params['unsubscribeUrl'] = Url::to(['/activity/user'], true);
            $mail = Yii::$app->mailer->compose([
                'html' => $this->layout,
                'text' => $this->layoutPlaintext
                    ], [
                'activities' => $outputHtml,
                'activitiesPlaintext' => $outputPlaintext,
            ]);

            $mail->setTo($this->user->email);
            $mail->setSubject($this->getSubject());
            if ($mail->send()) {
                $this->setLastSummaryDate();
                Yii::$app->i18n->autosetLocale();
                return true;
            }
        } catch (\Throwable $ex) {
            Yii::error('Could not send mail to: ' . $this->user->email . ' - Error:  ' . $ex->getMessage());
        } finally {
            Yii::$app->i18n->autosetLocale();
        }

        return false;
    }

    /**
     * Returns the subject of the MailSummary
     *
     * @return string the subject of mail summary
     */
    protected function getSubject()
    {
        if ($this->interval === self::INTERVAL_DAILY) {
            return Yii::t('ActivityModule.base', 'Your daily summary');
        }

        if ($this->interval === self::INTERVAL_HOURLY) {
            return Yii::t('ActivityModule.base', 'Latest news');
        }

        if ($this->interval === self::INTERVAL_WEEKLY) {
            return Yii::t('ActivityModule.base', 'Your weekly summary');
        }

        return '';
    }

    /**
     * Returns the list of activities for the e-mail summary
     *
     * @return BaseActivity[] the activities
     */
    public function getActivities()
    {
        $stream = new DashboardStreamAction('stream', Yii::$app->controller , [
            'activity' => true,
            'limit' => $this->maxActivityCount,
            'user' => $this->user,
        ]);

        $stream->init();

        $query = $stream->getStreamQuery()->query();
        $query->andWhere(['>', 'content.created_at', $this->getLastSummaryDate()]);

        // Handle suppressed activities
        $suppressedActivities = $this->getSuppressedActivities();
        if (!empty($suppressedActivities)) {
            $query->leftJoin('activity ax', 'ax.id=content.object_id');
            $query->andWhere(['NOT IN', 'ax.class', $suppressedActivities]);
        }

        // Handle defined content container mode
        $limitContainer = $this->getLimitContentContainers();
        if (!empty($limitContainer)) {
            $mode = ($this->getLimitContentContainerMode() == MailSummaryForm::LIMIT_MODE_INCLUDE) ? 'IN' : 'NOT IN';
            $query->andWhere([$mode, 'content.contentcontainer_id', $limitContainer]);
        }

        $activities = [];
        foreach ($stream->getStreamQuery()->all() as $content) {
            try {
                $activity = $content->getPolymorphicRelation();
                if ($activity instanceof Activity) {
                    $activities[] = $activity->getActivityBaseClass();
                }
            } catch (Exception $ex) {
                Yii::error($ex->getMessage());
                return [];
            }
        }

        return $activities;
    }

    /**
     * Stores the date of the last summary mail
     */
    protected function setLastSummaryDate()
    {
        static::getModule()->settings->user($this->user)->set('mailSummaryLast', time());
    }

    /**
     * Returns the last summary date
     *
     * @return string|Expression of the last summary mail
     */
    protected function getLastSummaryDate()
    {
        $lastSent = (int) static::getModule()->settings->user($this->user)->get('mailSummaryLast');
        if (empty($lastSent)) {
            $lastSent = new Expression('NOW() - INTERVAL 24 HOUR');
        } else {
            $lastSent = date('Y-m-d G:i:s', $lastSent);
        }

        return $lastSent;
    }

    /**
     * Returns the mode (exclude, include) of given content containers
     *
     * @see MailSummaryForm
     * @return int mode
     */
    protected function getLimitContentContainerMode()
    {
        $activityModule = static::getModule();
        $default = $activityModule->settings->get('mailSummaryLimitSpacesMode', '');
        return $activityModule->settings->user($this->user)->get('mailSummaryLimitSpacesMode', $default);
    }

    /**
     * Returns a list of content containers which should be included or excluded.
     *
     * @return array list of contentcontainer ids
     */
    protected function getLimitContentContainers()
    {
        $spaces = [];
        $activityModule = static::getModule();
        $defaultLimitSpaces = $activityModule->settings->get('mailSummaryLimitSpaces', '');
        $limitSpaces = $activityModule->settings->user($this->user)->get('mailSummaryLimitSpaces', $defaultLimitSpaces);
        foreach (explode(',', $limitSpaces) as $guid) {
            $contentContainer = ContentContainer::findOne(['guid' => $guid]);
            if ($contentContainer !== null) {
                $spaces[] = $contentContainer->id;
            }
        }

        return $spaces;
    }

    /**
     * Returns a list of suppressed activity classes
     *
     * @return array suppressed activity class names
     */
    protected function getSuppressedActivities()
    {
        $activityModule = static::getModule();
        $defaultActivitySuppress = $activityModule->settings->get('mailSummaryActivitySuppress', '');
        $activitySuppress = $activityModule->settings->user($this->user)->get('mailSummaryActivitySuppress', $defaultActivitySuppress);
        if (empty($activitySuppress)) {
            return [];
        }

        return explode(',', trim($activitySuppress));
    }

    /**
     * @return Module
     */
    private static function getModule()
    {
        return Yii::$app->getModule('activity');
    }
}
