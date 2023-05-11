<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\user\widgets;

use an602\modules\space\models\Membership;
use an602\modules\space\models\Space;
use an602\modules\user\controllers\ImageController;
use an602\modules\user\models\User;
use Yii;

/**
 * Displays the profile header of a user
 *
 * @since 0.5
 * @author Luke
 */
class ProfileHeader extends \yii\base\Widget
{

    /**
     * @var User
     */
    public $user;

    /**
     * @var boolean is owner of the current profile
     */
    protected $isProfileOwner = false;

    /**
     * @inheritdoc
     */
    public function init()
    {
        /**
         * Try to autodetect current user by controller
         */
        if ($this->user === null) {
            $this->user = $this->getController()->getUser();
        }

        if (!Yii::$app->user->isGuest && Yii::$app->user->id == $this->user->id) {
            $this->isProfileOwner = true;
        }

        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $canEditProfileImage = ImageController::canEditProfileImage($this->user);

        return $this->render('profileHeader', [
            'user' => $this->user,
            'isProfileOwner' => $this->isProfileOwner,
            // Deprecated variables below (will removed in future versions)
            'allowModifyProfileImage' => $canEditProfileImage, // @deprecated since 1.4 only in use for legacy themes
            'allowModifyProfileBanner' => $canEditProfileImage, // @deprecated since 1.4 only in use for legacy themes
            'friendshipsEnabled' => Yii::$app->getModule('friendship')->getIsEnabled(),
            'followingEnabled' => !Yii::$app->getModule('user')->disableFollow,
            'countFriends' => -1,
            'countFollowers' => -1,
            'countFollowing' => -1,
            'countSpaces' => -1,
        ]);
    }

    /**
     * Returns the number of followed public space
     *
     * @return int the follow count
     */
    protected function getFollowingSpaceCount()
    {
        return Membership::getUserSpaceQuery($this->user)
            ->andWhere(['!=', 'space.visibility', Space::VISIBILITY_NONE])
            ->andWhere(['space.status' => Space::STATUS_ENABLED])
            ->count();
    }

}

?>
