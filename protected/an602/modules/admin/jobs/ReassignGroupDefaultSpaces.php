<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2020 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\admin\jobs;

use an602\modules\queue\ActiveJob;
use an602\modules\queue\interfaces\ExclusiveJobInterface;
use an602\modules\user\models\Group;

/**
 * Reassign default spaces to all users
 *
 * @since 1.8
 */
class ReassignGroupDefaultSpaces extends ActiveJob implements ExclusiveJobInterface
{
    /**
     * @var int group id
     */
    public $groupId;

    /**
     * @inheritDoc
     */
    public function run()
    {
        $group = Group::findOne(['id' => $this->groupId]);

        if ($group !== null) {
            foreach ($group->groupUsers as $user) {
                foreach ($group->groupSpaces as $space) {
                    if ($space !== null) {
                        $space->space->addMember($user->user_id);
                    }
                }
            }
        }
    }

    public function getExclusiveJobId()
    {
        return 'admin.reassign-default-spaces-for-group-id-' . $this->groupId;
    }
}
