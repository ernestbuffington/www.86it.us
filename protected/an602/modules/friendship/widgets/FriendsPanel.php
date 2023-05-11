<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2016 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\friendship\widgets;

use Yii;
use an602\modules\friendship\models\Friendship;

/**
 * A panel which shows users friends in sidebar
 *
 * @since 1.1
 * @author luke
 */
class FriendsPanel extends \yii\base\Widget
{

    /**
     * @var User the target user 
     */
    public $user;

    /**
     * @var int limit of friends to display
     */
    public $limit = 30;

    /**
     * @inheritdoc
     */
    public function run()
    {
        if (!Yii::$app->getModule('friendship')->getIsEnabled()) {
            return;
        }

        $querz = Friendship::getFriendsQuery($this->user);

        $totalCount = $querz->count();
        $friends = $querz->limit($this->limit)->all();

        return $this->render('friendsPanel', [
                    'friends' => $friends,
                    'friendsShowLimit' => $this->limit,
                    'totalCount' => $totalCount,
                    'limit' => $this->limit,
                    'user' => $this->user,
        ]);
    }

}
