<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2018 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 *
 */

namespace an602\modules\topic\controllers;

use an602\modules\user\models\User;
use an602\widgets\ModalClose;
use an602\modules\content\components\ContentContainerController;
use an602\modules\topic\models\Topic;
use an602\modules\topic\permissions\ManageTopics;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\HttpException;

class ManageController extends ContentContainerController
{
    public function getAccessRules()
    {
        return [
            ['login'],
            ['permission' => ManageTopics::class],
            ['json' => ['delete']]
        ];
    }

    public function init()
    {
        parent::init();

        if($this->contentContainer instanceof User) {
            $this->subLayout = "@an602/modules/user/views/account/_layout";
        }
    }

    public function actionIndex()
    {
        $model = new Topic($this->contentContainer);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->view->saved();
        }

        if ($model->hasErrors()) {
            $this->view->error($model->getFirstError('name'));
        }

        $title = $this->contentContainer instanceof User
            ? Yii::t('UserModule.account', '<strong>Account</strong> Settings')
            : Yii::t('TopicModule.base', '<strong>Topic</strong> Overview');

        return $this->render('overview', [
            'contentContainer' => $this->contentContainer,
            'dataProvider' => $this->getTopicProvider(),
            'addModel' => new Topic(),
            'title' => $title
        ]);
    }

    private function getTopicProvider()
    {
        return new ActiveDataProvider([
            'query' =>  Topic::findByContainer($this->contentContainer)->orderBy('sort_order, name'),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
    }

    public function actionDelete($id)
    {
        $this->forcePostRequest();

        $topic = Topic::findOne(['id' => $id]);
        if ($topic) {
            $topic->delete();
            return ['success' => true, 'message' => Yii::t('TopicModule.base', 'Topic has been deleted!')];
        }

        return ['success' => false];
    }

    public function actionEdit($id)
    {
        $topic = Topic::findOne(['id' => $id]);

        if (!$topic) {
            throw new HttpException(404);
        }

        if ($topic->load(Yii::$app->request->post()) && $topic->save()) {
            return ModalClose::widget([
                'saved' => true,
                'reload' => true
            ]);
        }

        return $this->renderAjax('editModal', [
            'model' => $topic,
        ]);
    }
}
