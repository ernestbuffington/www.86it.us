<?php

namespace an602\modules\admin\models\forms;

use an602\modules\admin\permissions\ManageGroups;
use an602\modules\user\models\Group;
use an602\modules\user\models\GroupUser;
use an602\modules\user\models\User;
use Yii;

/**
 * Description of UserEditForm
 *
 * @author buddha
 */
class UserEditForm extends User
{
    /**
     * GroupId selection array of the form.
     * @var array
     */
    public $groupSelection;

    /**
     * Current member groups (models) of the given $user
     * @var Group[]
     */
    public $currentGroups;

    /**
     * @inheritdoc
     */
    public function initGroupSelection()
    {
        $this->currentGroups = $this->groups;

        //Set the current group selection
        $this->groupSelection = [];
        foreach ($this->currentGroups as $group) {
            $this->groupSelection[] = $group->id;
        }

        parent::init();
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['editAdmin'][] = 'groupSelection';

        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [['groupSelection', 'required']]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), ['groupSelection' => $this->getGroupLabel()]);
    }

    public function getGroupLabel()
    {
        if(!Yii::$app->user->isAdmin() && $this->isSystemAdmin()) {
            return Yii::t('AdminModule.base', 'Groups (Note: The Administrator group of this user can\'t be managed with your permissions)');
        }

        return Yii::t('AdminModule.base', 'Groups');
    }

    /**
     * Aligns the given group selection with the db
     * @return boolean
     */
    public function afterSave($insert, $changedAttributes)
    {
        if (Yii::$app->user->can(new ManageGroups())) {
            //Check old group selection and remove non selected groups
            foreach ($this->currentGroups as $userGroup) {
                if (!$this->isInGroupSelection($userGroup)) {
                    /* @var $groupUser GroupUser */
                    $groupUser = $this->getGroupUsers()->where(['group_id' => $userGroup->id])->one();
                    if(!$groupUser->group->is_admin_group || Yii::$app->user->isAdmin()) {
                        $groupUser->delete();
                    }
                }
            }

            $this->groupSelection = ($this->groupSelection == null) ? [] : $this->groupSelection;

            //Add all new selectedGroups to the given user
            foreach ($this->groupSelection as $groupId) {
                if (!$this->isCurrentlyMemberOf($groupId)) {
                    /* @var $group Group */
                    $group = Group::findOne(['id' => $groupId]);
                    if ($group && (!$group->is_admin_group || Yii::$app->user->isAdmin())) {
                        $group->addUser($this);
                    }
                }
            }
        }

        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * Checks if the given group (id or model object) is contained in the form selection
     * @param int|Group $groupId groupId or Group model object
     * @return boolean true if contained in selection else false
     */
    private function isInGroupSelection($groupId)
    {
        $groupId = ($groupId instanceof Group) ? $groupId->id : $groupId;
        $this->groupSelection = (is_array($this->groupSelection)) ? $this->groupSelection : [];

        return is_array($this->groupSelection) && in_array($groupId, $this->groupSelection);
    }

    /**
     * Checks if the user is member of the given group (id or model object)
     * @param integer $groupId $groupId groupId or Group model object
     * @return boolean true if user is member else false
     */
    private function isCurrentlyMemberOf($groupId)
    {
        $groupId = ($groupId instanceof Group) ? $groupId->id : $groupId;
        foreach ($this->currentGroups as $userGroup) {
            if ($userGroup->id === $groupId) {
                return true;
            }
        }

        return false;
    }

    /**
     * Returns an id => groupname array representation of the given $groups array.
     * @param array $groups array of Group models
     * @return array in form of id => groupname
     */
    public static function getGroupItems($groups = null)
    {
        if(!$groups) {
            $groups = (Yii::$app->user->isAdmin()) ? Group::find()->all() :  Group::findAll(['is_admin_group' => '0']) ;
        }

        $result = [];
        foreach ($groups as $group) {
            $result[$group->id] = $group->name . ($group->is_default_group ? ' (' . Yii::t('AdminModule.base', 'Default') . ')' : '');
        }

        return $result;
    }
}
