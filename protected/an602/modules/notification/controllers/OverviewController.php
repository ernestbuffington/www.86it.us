<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\notification\controllers;

use an602\components\access\ControllerAccess;
use an602\components\Controller;
use an602\modules\notification\models\forms\FilterForm;
use an602\modules\notification\models\Notification;
use an602\modules\notification\widgets\OverviewWidget;
use Yii;
use yii\db\IntegrityException;

/**
 * ListController
 *
 * @package an602.modules_core.notification.controllers
 * @since 0.5
 */
class OverviewController extends Controller
{
    const PAGINATION_PAGE_SIZE = 20;

    /**
     * @inheritdoc
     */
    public function getAccessRules()
    {
        return [
            [ControllerAccess::RULE_LOGGED_IN_ONLY]
        ];
    }

    /**
     * @param bool $reload if the request is a reload request
     * @return string
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionIndex($reload = false)
    {
        $filterForm = $this->loadFilterForm($reload);

        if ($filterForm->hasFilter()) {
            $overview = OverviewWidget::widget([
                'pagination' => $filterForm->getPagination(self::PAGINATION_PAGE_SIZE),
                'notifications' => $this->prepareNotifications($filterForm->createQuery()->all()),
            ]);
        } else {
            $overview = OverviewWidget::widget([
                'notifications' => [],
            ]);
        }

        return $reload
            ? $this->renderAjaxPartial($overview)
            : $this->render('index', [
                'overview' => $overview,
                'filterForm' => $filterForm,
            ]);
    }

    /**
     * Loads the filters from the request into the form
     *
     * @param bool $reload
     * @return FilterForm
     */
    private function loadFilterForm(bool $reload = false): FilterForm
    {
        $filterForm = new FilterForm();

        if ($reload) {
            $filterForm->load(Yii::$app->request->post());
        } else {
            $filterForm->load(Yii::$app->request->get());
        }

        return $filterForm;
    }

    /**
     * Validates given notifications and returns a list of notification models of all valid notifications.
     *
     * @param $notifications Notification[]
     * @return array
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    private function prepareNotifications($notifications)
    {
        $result = [];
        foreach ($notifications as $notificationRecord) {
            /* @var $notificationRecord \an602\modules\notification\models\Notification */

            try {
                $baseModel = $notificationRecord->getBaseModel();

                if ($baseModel->validate()) {
                    $result[] = $baseModel;
                } else {
                    throw new IntegrityException('Invalid base model (' . $notificationRecord->class . ') found for notification');
                }

            } catch (IntegrityException $ex) {
                $notificationRecord->delete();
                Yii::warning('Deleted inconsistent notification with id ' . $notificationRecord->id . '. ' . $ex->getMessage());
            }
        }
        return $result;
    }
}
