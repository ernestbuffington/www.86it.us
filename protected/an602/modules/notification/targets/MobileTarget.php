<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\notification\targets;

use an602\modules\user\models\User;
use an602\modules\notification\components\BaseNotification;
use Yii;
use yii\di\NotInstantiableException;

/**
 * Mobile Target
 *
 * @since 1.2
 * @author buddha
 */
class MobileTarget extends BaseTarget
{

    /**
     * @inheritdoc
     */
    public $id = 'mobile';

    /**
     * @var MobileTargetProvider
     */
    public $provider;

    public function init()
    {
        parent::init();

        try {
            $this->provider = Yii::$container->get(MobileTargetProvider::class);
        } catch (NotInstantiableException $e) {
            // No provider given
        }
    }

    /**
     * Used to forward a BaseNotification object to a BaseTarget.
     * The notification target should handle the notification by pushing a Job to
     * a Queue or directly handling the notification.
     *
     * @param BaseNotification $notification
     */
    public function handle(BaseNotification $notification, User $user)
    {
        if($this->provider) {
            $this->provider->handle($notification, $user);
        }
    }

    /**
     * @inheritdoc
     */
    public function getTitle()
    {
        return Yii::t('NotificationModule.targets', 'Mobile');
    }

    public function isActive(User $user = null)
    {
        if(!parent::isActive() || !$this->provider) {
            return false;
        }

        return $this->provider->isActive($user);
    }

}
