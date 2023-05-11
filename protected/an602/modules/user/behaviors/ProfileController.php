<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\user\behaviors;

use an602\modules\content\components\ContentContainerController;
use an602\modules\user\helpers\AuthHelper;
use Yii;
use yii\base\Behavior;
use yii\base\InvalidValueException;
use yii\web\HttpException;
use an602\modules\user\models\User;
use an602\components\Controller;

/**
 * ProfileController Behavior
 *
 * In User container scopes, this behavior will automatically attached to a contentcontainer controller.
 *
 * @see User::controllerBehavior
 * @see ContentContainerController
 * @property ContentContainerController $owner the controller
 */
class ProfileController extends Behavior
{

    /**
     * @var User the user
     */
    public $user = null;

    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            Controller::EVENT_BEFORE_ACTION => 'beforeAction',
        ];
    }

    /**
     * @inheritdoc
     */
    public function attach($owner)
    {
        parent::attach($owner);

        if (!$this->owner->contentContainer instanceof User) {
            throw new InvalidValueException('Invalid contentcontainer type of controller.');
        }

        $this->user = $this->owner->contentContainer;
    }

    /**
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param $action
     * @throws HttpException
     */
    public function beforeAction($action)
    {
        if ($this->user->status == User::STATUS_NEED_APPROVAL) {
            throw new HttpException(404, Yii::t('UserModule.profile', 'This user account is not approved yet!'));
        }

        if ($this->user->status == User::STATUS_SOFT_DELETED) {
            throw new HttpException(404, Yii::t('UserModule.profile', 'This profile is no longer available!'));
        }

        if (AuthHelper::isGuestAccessEnabled() && $this->user->visibility != User::VISIBILITY_ALL && Yii::$app->user->isGuest) {
            throw new HttpException(401, Yii::t('UserModule.profile', 'You need to login to view this user profile!'));
        }

        $this->owner->prependPageTitle($this->user->displayName);

        if(empty($this->owner->subLayout)) {
            $this->owner->subLayout = "@an602/modules/user/views/profile/_layout";
        }
    }

}

?>
