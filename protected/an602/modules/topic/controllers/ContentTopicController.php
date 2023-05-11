<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2018 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 *
 */

namespace an602\modules\topic\controllers;

use an602\widgets\ModalClose;
use an602\components\Controller;
use an602\modules\content\models\Content;
use an602\modules\topic\models\forms\ContentTopicsForm;
use Yii;
use yii\web\HttpException;

class ContentTopicController extends Controller
{
    public function actionIndex($contentId)
    {
        $content = Content::findOne(['id' => $contentId]);

        if (!$content) {
            throw new HttpException(404);
        } elseif (!$content->canEdit()) {
            throw new HttpException(403);
        }

        $form = new ContentTopicsForm(['content' => $content]);

        if ($form->load(Yii::$app->request->post()) && $form->save()) {
            $entrySelector = '$(\'[data-ui-widget="stream.StreamEntry"][data-content-key='.$content->id.']\')';
            return ModalClose::widget(['script' => 'an602.modules.action.Component.instance('.$entrySelector.').reload()']);
        }

        return $this->renderAjax('edit', ['model' => $form]);
    }
}
