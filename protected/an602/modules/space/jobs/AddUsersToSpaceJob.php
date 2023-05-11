<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\space\jobs;

use an602\modules\queue\ActiveJob;
use an602\modules\space\models\Space;
use an602\modules\space\notifications\UserAddedNotification;
use an602\modules\user\models\User;
use Yii;
use yii\base\Exception;

class AddUsersToSpaceJob extends ActiveJob
{
    /**
     * @var Space target space
     */
    private $space;

    /**
     * @var int
     */
    public $spaceId;

    /**
     * @var int[]
     */
    public $userIds;

    /**
     * @var User originator user
     */
    private $originator;

    /**
     * @var User originator user id
     */
    public $originatorId;

    /**
     * @var bool
     */
    public $allUsers = false;

    /**
     * @var bool
     */
    public $forceMembership = false;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->space = Space::findOne(['id' => $this->spaceId]);
        $this->originator = User::findOne(['id' => $this->originatorId]);
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        if ($this->allUsers) {
            foreach (User::find()->active()->batch() as $users) {
                $this->addUsers($users);
            }
        } else {
            $this->addUsers($this->userIds);
        }
    }

    /**
     * @param User[]|int[] $users
     */
    private function addUsers($users)
    {
        foreach ($users as $user) {
            try {
                $user = ($user instanceof User) ? $user : User::findOne(['id' => $user]);

                if (!$user || $user->id === $this->originator->id) {
                    continue;
                }

                $this->space->inviteMember($user->id, $this->originator->id, !$this->forceMembership);

                if ($this->forceMembership) {
                    $this->space->addMember($user->id, 2, true);
                    UserAddedNotification::instance()->from($this->originator)->about($this->space)->send($user);
                }
            } catch (Exception $e) {
                Yii::error($e);
            }
        }
    }
}
