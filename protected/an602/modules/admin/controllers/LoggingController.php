<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2018 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\admin\controllers;

use Yii;
use an602\modules\admin\models\forms\LogFilterForm;
use an602\modules\admin\components\Controller;
use an602\modules\admin\permissions\SeeAdminInformation;
use an602\modules\admin\models\Log;

/**
 * LoggingController provides access to the database logging.
 *
 * @since 0.5
 */
class LoggingController extends Controller
{

    /**
     * @inheritdoc
     */
    public $adminOnly = false;

    public function init()
    {
        $this->appendPageTitle(Yii::t('AdminModule.base', 'Logging'));
        $this->subLayout = '@admin/views/layouts/information';

		return parent::init();
    }

    /**
     * @inheritdoc
     */
    public function getAccessRules()
    {
        return [
            ['permissions' => SeeAdminInformation::class]
        ];
    }

    public function actionIndex()
    {
        $filter = new LogFilterForm();

        if(Yii::$app->request->post()) {
            $filter->load(Yii::$app->request->post());
        } else {
            $filter->load(Yii::$app->request->get());
        }

        $params = [
            'filter' => $filter,
            'logEntries' => $filter->findEntries(),
            'pagination' => $filter->getPagination(),
        ];

        if(Yii::$app->request->isAjax && !Yii::$app->request->isPjax) {
            return $this->asJson([
                'html' => $this->renderPartial('log_entries', $params),
                'url' => $filter->getUrl()
            ]);
        }

        return $this->render('index', $params);
    }

    public function actionFlush()
    {
        $this->forcePostRequest();
        Log::deleteAll();

		return $this->redirect(['index']);
    }

}
