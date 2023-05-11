<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2021 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\stream\models\filters;

use an602\modules\user\models\User;

class BlockedUsersStreamFilter extends StreamQueryFilter
{
    /**
     * @var array IDs of the blocked users for the current User
     */
    private $blockedUsers;

    public function init() {
        parent::init();

        if (!empty($this->streamQuery->user) && $this->streamQuery->user instanceof User) {
            $this->blockedUsers = $this->streamQuery->user->getBlockedUserIds();
        }
    }

    public function apply()
    {
        if (empty($this->blockedUsers)) {
            return;
        }

        $this->query->andWhere(['NOT IN', 'user.id', $this->blockedUsers]);
    }
}
