<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2021 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\user\widgets;

use an602\components\Widget;
use an602\modules\friendship\widgets\FriendshipButton;
use an602\modules\user\models\User;

/**
 * PeopleActionsButton shows directory options (following or friendship) for listed users
 *
 * @since 1.9
 * @author Luke
 */
class PeopleActionButtons extends Widget
{

    /**
     * @var User
     */
    public $user;

    /**
     * @var string Template for buttons
     */
    public $template = '{buttons}';

    /**
     * @inheritdoc
     */
    public function run()
    {
        $html = $this->addFollowButton();
        $html .= $this->addFriendshipButton();

        if (trim($html) === '') {
            return '';
        }

        return str_replace('{buttons}', $html, $this->template);
    }


    protected function addFollowButton(): string
    {
        return UserFollowButton::widget([
            'user' => $this->user,
            'followOptions' => ['class' => 'btn btn-primary btn-sm'],
            'unfollowOptions' => ['class' => 'btn btn-primary btn-sm active'],
        ]);
    }

    protected function addFriendshipButton(): string
    {
        return FriendshipButton::widget([
            'user' => $this->user,
            'options' => [
                'friends' => ['attrs' => ['class' => 'btn btn-info btn-sm active']],
                'addFriend' => ['attrs' => ['class' => 'btn btn-info btn-sm']],
                'acceptFriendRequest' => ['attrs' => ['class' => 'btn btn-info btn-sm active'], 'togglerClass' => 'btn btn-info btn-sm active'],
                'cancelFriendRequest' => ['attrs' => ['class' => 'btn btn-info btn-sm active']],
            ],
        ]);
    }

}
