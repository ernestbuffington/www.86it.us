<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2016 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\user\models;

use an602\components\ActiveRecord;
use an602\modules\search\libs\SearchHelper;

/**
 * This is the model class for table "group_admin".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $group_id
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * @property User $user
 * @property Group $group
 */
class GroupUser extends ActiveRecord
{

    const SCENARIO_REGISTRATION = 'registration';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'group_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'group_id'], 'required'],
            [['user_id', 'group_id'], 'integer'],
            [['group_id'], 'validateGroupId'],
            [['user_id', 'group_id'], 'unique', 'targetAttribute' => ['user_id', 'group_id'], 'message' => 'The combination of User ID and Group ID has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_REGISTRATION] = ['group_id'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'group_id' => 'Group ID',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
            if ($this->group !== null && $this->group->groupSpaces !== null) {
                foreach ($this->group->groupSpaces as $groupSpace) {
                    $groupSpace->space->addMember($this->user->id);
                }
            }
            if ($this->user !== null) {
                $this->user->updateSearch();
            }
        }

        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @inheritdoc
     */
    public function afterDelete()
    {
        SearchHelper::queueUpdate($this->user);
        parent::afterDelete();
    }

    /**
     * Returns all Group relation
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(Group::class, ['id' => 'group_id']);
    }

    /**
     * Returns all User relation
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * Validator for group field during registration
     */
    public function validateGroupId()
    {
        if ($this->scenario == static::SCENARIO_REGISTRATION) {
            if ($this->group_id != '') {
                $registrationGroups = Group::getRegistrationGroups();
                foreach ($registrationGroups as $group) {
                    if ($this->group_id == $group->id) {
                        return;
                    }
                }

                // Not found group in groups available during registration
                $this->addError('group_id', 'Invalid group given!');
            }
        }
    }

}
