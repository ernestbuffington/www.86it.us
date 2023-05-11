<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2021 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\space\widgets;

use an602\modules\space\models\Space;
use yii\base\Widget;
use yii\helpers\Url;

/**
 * SpaceFollowers lists all followers of the Space
 *
 * @package an602.modules_core.space.widget
 * @since 1.10.0
 * @author Luke
 */
class SpaceFollowers extends Widget
{

    /**
     * @var Space
     */
    public $space;

    public function run()
    {
        $followersQuery = $this->space->getFollowersQuery();

        $totalFollowerCount = $followersQuery->count();
        if (!$totalFollowerCount) {
            return '';
        }

        return $this->render('spaceFollowers', [
            'followers' => $followersQuery->limit(16)->all(),
            'totalFollowerCount' => $totalFollowerCount,
            'showListOptions' => [
                'data-action-click' => 'ui.modal.load',
                'data-action-url' => Url::to(['/space/space/follower-list', 'container' => $this->space])
            ]
        ]);
    }

}
