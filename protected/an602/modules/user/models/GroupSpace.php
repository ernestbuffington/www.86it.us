<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2016 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\user\models;

use an602\modules\space\models\Space;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "group_spaces".
 *
 * @property int $id
 * @property int $space_id
 * @property int $group_id
 *
 * @property Group $group
 * @property Space $space
 */
class GroupSpace extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'group_space';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['space_id', 'group_id'], 'required'],
            [['space_id', 'group_id'], 'integer'],
            [['space_id', 'group_id'], 'unique', 'targetAttribute' => ['space_id', 'group_id']],
            [['group_id'], 'exist', 'skipOnError' => true, 'targetClass' => Group::class, 'targetAttribute' => ['group_id' => 'id']],
            [['space_id'], 'exist', 'skipOnError' => true, 'targetClass' => Space::class, 'targetAttribute' => ['space_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'space_id' => 'Space ID',
            'group_id' => 'Group ID',
        ];
    }

    /**
     * Gets query for [[Group]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(Group::class, ['id' => 'group_id']);
    }

    /**
     * Gets query for [[Space]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSpace()
    {
        return $this->hasOne(Space::class, ['id' => 'space_id']);
    }
}


