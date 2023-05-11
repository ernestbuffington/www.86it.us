<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\user\controllers;

use an602\modules\admin\permissions\ManageUsers;
use an602\modules\content\controllers\ContainerImageController;
use an602\modules\content\models\ContentContainer;
use an602\modules\user\components\PermissionManager;
use an602\modules\user\models\User;
use Yii;
use yii\web\HttpException;

/**
 * ImageController handles user profile or user banner image modifications
 *
 * @since 1.2
 * @author Luke
 */
class ImageController extends ContainerImageController
{
    public $validContentContainerClasses = [User::class];

    public function init()
    {
        $legacyUserGuid = Yii::$app->request->get('userGuid');

        if ($legacyUserGuid) {
            $this->validContentContainerClasses = null;
            $this->requireContainer = false;
        }

        parent::init();

        if ($legacyUserGuid) {
            $contentContainerModel = ContentContainer::findOne(['guid' => $legacyUserGuid]);
            if ($contentContainerModel !== null) {
                $this->contentContainer = $contentContainerModel->getPolymorphicRelation();
            }

            if (!$this->contentContainer) {
                throw new HttpException(404);
            }
        }
    }

    public function getAccessRules()
    {
        return [
            ['validateAccess'],
        ];
    }

    public function validateAccess($rule, $access)
    {
        if (!static::canEditProfileImage($this->contentContainer)) {
            $access->code = 401;
            $access->reason = 'Not authorized!';
            return false;
        }

        return true;
    }

    public static function canEditProfileImage(User $userProfile)
    {
        if (Yii::$app->user->isGuest) {
            return false;
        }

        /** @var User $user */
        $user = Yii::$app->user->getIdentity();

        if ($userProfile->is($user)) {
            return true;
        }

        if (Yii::$app->getModule('user')->adminCanChangeUserProfileImages && Yii::$app->user->can(ManageUsers::class)) {
            return true;
        }

        return false;
    }
}
