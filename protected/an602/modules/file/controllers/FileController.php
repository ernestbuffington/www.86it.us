<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\file\controllers;

use an602\components\access\ControllerAccess;
use an602\components\Controller;
use Yii;
use yii\web\HttpException;
use an602\modules\file\actions\DownloadAction;
use an602\modules\file\actions\UploadAction;
use an602\modules\file\models\File;

/**
 * UploadController provides uploading functions for files
 *
 * @since 0.5
 */
class FileController extends Controller
{
    /**
     * @inheritdoc
     */
    protected $access = ControllerAccess::class;

    /**
     * @inheritdoc
     */
    public function getAccessRules()
    {
        return [
            [ControllerAccess::RULE_LOGGED_IN_ONLY => ['upload', 'delete']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'download' => [
                'class' => DownloadAction::class,
            ],
            'upload' => [
                'class' => UploadAction::class,
            ],
        ];
    }

    public function actionDelete()
    {
        $this->forcePostRequest();

        $guid = Yii::$app->request->post('guid');
        $file = File::findOne(['guid' => $guid]);

        if ($file == null) {
            throw new HttpException(404, Yii::t('FileModule.base', 'Could not find requested file!'));
        }

        if (!$file->canDelete()) {
            throw new HttpException(401, Yii::t('FileModule.base', 'Insufficient permissions!'));
        }

        $file->delete();

        Yii::$app->response->format = 'json';
        return ['success' => true];
    }

}
