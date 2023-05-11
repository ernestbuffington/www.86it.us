<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2015 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\user\models\fieldtype;

use an602\modules\user\models\Profile;
use an602\modules\user\models\User;
use Yii;

/**
 * ProfileFieldTypeCheckbox handles numeric profile fields.
 *
 * @package an602.modules_core.user.models
 * @since 0.5
 */
class Checkbox extends BaseType
{
    /**
     * @inheritdoc
     */
    public $type = 'checkbox';

    /**
     * Field Default Checkbox
     *
     * @var Integer
     */
    public $default = 0;

    /**
     * Rules for validating the Field Type Settings Form
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['default'], 'in', 'range' => [0, 1]]
        ];
    }

    /**
     * Returns Form Definition for edit/create this field.
     *
     * @return array Form Definition
     */
    public function getFormDefinition($definition = [])
    {
        return parent::getFormDefinition([
            get_class($this) => [
                'type' => 'form',
                'title' => Yii::t('UserModule.profile', 'Checkbox field options'),
                'elements' => [
                    'default' => [
                        'label' => Yii::t('UserModule.profile', 'Default value'),
                        'class' => 'form-control',
                        'type' => 'dropdownlist',
                        'items' => [
                            0 => 'Unchecked',
                            1 => 'Checked'
                        ]
                    ]
                ]
            ]
        ]);
    }

    /**
     * Saves this Profile Field Type
     */
    public function save()
    {
        $columnName = $this->profileField->internal_name;
        if (!\an602\modules\user\models\Profile::columnExists($columnName)) {
            $query = Yii::$app->db->getQueryBuilder()->addColumn(\an602\modules\user\models\Profile::tableName(), $columnName, 'INT(1) DEFAULT '.$this->default);
            Yii::$app->db->createCommand($query)->execute();
        }

        return parent::save();
    }

    /**
     * Returns the Field Rules, to validate users input
     *
     * @param array $rules
     * @return array rules
     */
    public function getFieldRules($rules = [])
    {
        $profileField = $this->profileField;
        if ($profileField->required) {
            $rules[] = [$profileField->internal_name, function($attribute) use ($profileField) {
                if (!$this->$attribute) {
                    $this->addError($attribute, Yii::t('UserModule.profile', '{attribute} is required!', ['{attribute}' => $profileField->title]));
                }
            }, 'except' => Profile::SCENARIO_EDIT_ADMIN];
        } else {
            $rules[] = [$profileField->internal_name, 'in', 'range' => [0, 1]];
        }
        return parent::getFieldRules($rules);
    }

    /**
     * @inheritdoc
     */
    public function getUserValue(User $user, $raw = true): ?string
    {
        $internalName = $this->profileField->internal_name;

        $value = $user->profile->$internalName;
        if (!$raw && !empty($value)) {
            $labels = $this->getLabels();
            return $labels[$internalName];
        }

        return $value;
    }
}
