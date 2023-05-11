<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\activity\controllers;

use Yii;
use an602\components\Controller;
use an602\modules\activity\models\Activity;
use yii\web\HttpException;

/**
 * LinkController provides link informations about an Activity via JSON.
 *
 * @author luke
 */
class LinkController extends Controller
{

    /**
     * Returns the link for the given activity.
     */
    public function actionIndex()
    {
        $activityId = Yii::$app->request->get('id');
        $activity = Activity::findOne(['id' => $activityId]);

        if ($activity !== null && $activity->content->canView()) {
            $this->redirect($activity->getActivityBaseClass()->getUrl());
        } else {
            throw new HttpException(403);
        }
    }

}
