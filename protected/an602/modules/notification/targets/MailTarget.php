<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\notification\targets;

use Yii;
use an602\modules\notification\components\BaseNotification;
use an602\modules\user\models\User;

/**
 *
 * @author buddha
 */
class MailTarget extends BaseTarget
{

    /**
     * @inheritdoc
     */
    public $id = 'email';

    /**
     * Enable this target by default.
     * @var boolean
     */
    public $defaultSetting = true;

    /**
     * @var array Notification mail layout.
     */
    public $view = [
        'html' => '@notification/views/mails/wrapper',
        'text' => '@notification/views/mails/plaintext/wrapper'
    ];

    /**
     * @inheritdoc
     */
    public function getTitle()
    {
        return Yii::t('NotificationModule.targets', 'E-Mail');
    }

    /**
     * @inheritdoc
     */
    public function handle(BaseNotification $notification, User $recipient)
    {
        Yii::$app->i18n->setUserLocale($recipient);

        Yii::$app->view->params['showUnsubscribe'] = true;
        Yii::$app->view->params['unsubscribeUrl'] = \yii\helpers\Url::to(['/notification/user'], true);

        // Note: the renderer is configured in common.php by default its an instance of MailTarget
        $renderer = $this->getRenderer();

        $viewParams = \yii\helpers\ArrayHelper::merge([
                    'headline' => '',
                    'notification' => $notification,
                    'space' => $notification->getSpace(),
                    'content' => $renderer->render($notification),
                    'content_plaintext' => $renderer->renderText($notification)
                        ], $notification->getViewParams());

        if ($notification->originator) {
            $from = $notification->originator->displayName . ' (' . Yii::$app->name . ')';
        } else {
            $from = Yii::$app->settings->get('mailer.systemEmailName');
        }

        $mail = Yii::$app->mailer->compose($this->view, $viewParams)
                ->setFrom([Yii::$app->settings->get('mailer.systemEmailAddress') => $from])
                ->setTo($recipient->email)
                ->setSubject(str_replace("\n", " ", trim($notification->getMailSubject())));
        if ($replyTo = Yii::$app->settings->get('mailer.systemEmailReplyTo')) {
            $mail->setReplyTo($replyTo);
        }

        if ($notification->beforeMailSend($mail)) {
            $mail->send();
        }


        Yii::$app->i18n->autosetLocale();
    }

    /**
     * @inheritdoc
     */
    public function isActive(User $user = null)
    {
        // Do not send mail notifications for example content during installlation.
        return parent::isActive() && Yii::$app->params['installed'];
    }

}
