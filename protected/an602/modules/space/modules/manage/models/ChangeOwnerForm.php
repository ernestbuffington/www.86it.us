<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\space\modules\manage\models;

use an602\modules\space\models\Space;
use Yii;
use yii\base\Model;
use an602\modules\space\models\Membership;

/**
 * Form Model for space owner change
 *
 * @since 0.5
 */
class ChangeOwnerForm extends Model
{

    /**
     * @var \an602\modules\space\models\Space
     */
    public $space;

    /**
     * @var string owner id
     */
    public $ownerId;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['ownerId', 'required'],
            ['ownerId', 'in', 'range' => array_keys($this->getNewOwnerArray())]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ownerId' => Yii::t('SpaceModule.manage', 'Space owner'),
        ];
    }

    /**
     * Returns an array of all possible space owners
     * 
     * @return array containing the user id as key and display name as value
     */
    public function getNewOwnerArray()
    {
        $possibleOwners = [];

        $query = Membership::find()->joinWith(['user', 'user.profile'])->andWhere(['space_membership.group_id' => Space::USERGROUP_ADMIN, 'space_membership.space_id' => $this->space->id]);
        foreach ($query->all() as $membership) {
            $possibleOwners[$membership->user->id] = $membership->user->displayName;
        }

        return $possibleOwners;
    }

}
