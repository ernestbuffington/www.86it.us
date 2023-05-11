<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2016 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\friendship\controllers;


use an602\modules\friendship\models\Friendship;
use an602\modules\friendship\models\SettingsForm;
use an602\modules\user\components\BaseAccountController;
use yii\data\ActiveDataProvider;


/**
 * Membership Manage Controller
 *
 * @author luke
 */
class ManageController extends BaseAccountController
{

    public function actionIndex()
    {
        return $this->redirect(['list']);
    }

    public function actionList()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Friendship::getFriendsQuery($this->getUser()),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('list', [
            'user' => $this->getUser(),
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionRequests()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Friendship::getReceivedRequestsQuery($this->getUser()),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('requests', [
            'user' => $this->getUser(),
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionSentRequests()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Friendship::getSentRequestsQuery($this->getUser()),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('sent-requests', [
            'user' => $this->getUser(),
            'dataProvider' => $dataProvider
        ]);
    }

}
