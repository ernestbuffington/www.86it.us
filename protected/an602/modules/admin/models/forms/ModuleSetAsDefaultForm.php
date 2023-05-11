<?php

namespace an602\modules\admin\models\forms;

use an602\modules\content\components\ContentContainerModuleManager;
use an602\modules\content\models\ContentContainerModuleState;
use an602\modules\space\models\Space;
use an602\modules\user\models\User;
use Yii;
use yii\base\Model;

/**
 * GroupForm is used to modify group settings
 *
 * @package an602.modules_core.admin.forms
 * @since 0.5
 */
class ModuleSetAsDefaultForm extends Model
{
    /** @var string */
    protected $moduleId;

    /** @var int | string */
    public $spaceDefaultState;

    /** @var int | string */
    public $userDefaultState;

    /**
     * Validation rules for group form
     *
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            [['userDefaultState', 'spaceDefaultState'], 'in', 'range' => ContentContainerModuleState::getStates()],
        ];
    }

    /**
     * @inheritDoc
     */
    public function attributeLabels()
    {
        return [
            'spaceDefaultState' => Yii::t('AdminModule.modules', 'Space default state'),
            'userDefaultState' => Yii::t('AdminModule.modules', 'User default state')
        ];
    }

    /**
     * @return array
     */
    public function getStatesList()
    {
        return ContentContainerModuleState::getStates(true);
    }

    /**
     * @param $id
     * @return $this
     */
    public function setModule($id): self
    {
        if ($this->moduleId == $id) {
            return $this;
        }

        $this->moduleId = $id;
        $this->spaceDefaultState = ContentContainerModuleManager::getDefaultState(Space::class, $id) ?? ContentContainerModuleState::STATE_DISABLED;
        $this->userDefaultState = ContentContainerModuleManager::getDefaultState(User::class, $id) ?? ContentContainerModuleState::STATE_DISABLED;

        return $this;
    }

    /**
     * @return bool
     */
    public function save($validate = true)
    {
        if ($validate && !$this->validate()) {
            return false;
        }

        ContentContainerModuleManager::setDefaultState(User::class, $this->moduleId, $this->userDefaultState);
        ContentContainerModuleManager::setDefaultState(Space::class, $this->moduleId, $this->spaceDefaultState);

        return true;
    }
}
