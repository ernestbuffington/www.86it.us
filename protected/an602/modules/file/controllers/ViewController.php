<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\file\controllers;

use Yii;
use yii\web\HttpException;
use an602\components\behaviors\AccessControl;
use an602\modules\file\models\File;
use an602\modules\file\handler\FileHandlerCollection;

/**
 * ViewControllers provides the open modal for files
 *
 * @since 1.2
 */
class ViewController extends \an602\components\Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'acl' => [
                'class' => AccessControl::class,
                'guestAllowedActions' => ['index']
            ],
        ];
    }

    public function actionIndex()
    {
        $guid = Yii::$app->request->get('guid');
        $file = File::findOne(['guid' => $guid]);

        if (!$file) {
            throw new HttpException(404, Yii::t('FileModule.base', 'Could not find requested file!'));
        }

        $viewHandler = FileHandlerCollection::getByType(FileHandlerCollection::TYPE_VIEW, $file);
        $exportHandler = FileHandlerCollection::getByType(FileHandlerCollection::TYPE_EXPORT, $file);

        $editHandler = [];
        $importHandler = [];
        if ($file->canDelete()) {
            $editHandler = FileHandlerCollection::getByType(FileHandlerCollection::TYPE_EDIT, $file);
            $importHandler = FileHandlerCollection::getByType(FileHandlerCollection::TYPE_IMPORT, $file);
        }

        return $this->renderAjax('index', [
                    'file' => $file,
                    'importHandler' => $importHandler,
                    'exportHandler' => $exportHandler,
                    'editHandler' => $editHandler,
                    'viewHandler' => $viewHandler
        ]);
    }

}
