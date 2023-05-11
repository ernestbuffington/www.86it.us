<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\user\jobs;

use Yii;
use yii\base\InvalidArgumentException;
use an602\modules\queue\ActiveJob;
use an602\modules\queue\interfaces\ExclusiveJobInterface;
use an602\modules\user\models\User;

/**
 * Soft deletes a user
 *
 * @since 1.3
 * @author Luke
 */
class SoftDeleteUser extends ActiveJob implements ExclusiveJobInterface
{

    public $user_id;

    /**
     * @inhertidoc
     */
    public function getExclusiveJobId()
    {
        if (empty($this->user_id)) {
            throw new InvalidArgumentException('User id cannot be empty!');
        }

        return 'user.softDeleteUser.' . $this->user_id;
    }

    /**
     * @inhertidoc
     */
    public function run()
    {
        $user = User::findOne(['id' => $this->user_id]);
        if ($user === null) {
            return;
        }
        
        $user->softDelete();
    }

}
