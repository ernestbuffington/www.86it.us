<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\space\modules\manage\jobs;

use an602\modules\queue\ActiveJob;
use an602\modules\space\models\Membership;
use an602\modules\space\models\Space;
use yii\db\StaleObjectException;

class RemoveAllMembersFromSpaceJob extends ActiveJob
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
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->space = Space::findOne(['id' => $this->spaceId]);
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        foreach (Membership::findAll(['space_id' => $this->space->id, 'group_id' => [Space::USERGROUP_MEMBER, Space::USERGROUP_USER, Space::USERGROUP_GUEST]]) as $spaceMembership) {
            try {
                $spaceMembership->delete();
            } catch (StaleObjectException|\Exception $e) {
            }
        }
    }
}
