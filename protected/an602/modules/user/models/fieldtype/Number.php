<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2015 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\user\models\fieldtype;

use Yii;

/**
 * ProfileFieldTypeNumber handles numeric profile fields.
 *
 * @package an602.modules_core.user.models
 * @since 0.5
 */
class Number extends BaseType
{

    /**
     * Maximum Int Value
     *
     * @var type
     */
    public $maxValue;

    /**
     * Minimum Int Value
     *
     * @var type
     */
    public $minValue;

    /**
     * Rules for validating the Field Type Settings Form
     *
     * @return type
     */
    public function rules()
    {
        return [
            [['maxValue', 'minValue'], 'integer', 'min' => 0],
        ];
    }

    /**
     * Returns Form Definition for edit/create this field.
     *
     * @return Array Form Definition
     */
    public function getFormDefinition($definition = [])
    {
        return parent::getFormDefinition([
                    get_class($this) => [
                        'type' => 'form',
                        'title' => Yii::t('UserModule.profile', 'Number field options'),
                        'elements' => [
                            'maxValue' => [
                                'label' => Yii::t('UserModule.profile', 'Maximum value'),
                                'type' => 'text',
                                'class' => 'form-control',
                            ],
                            'minValue' => [
                                'label' => Yii::t('UserModule.profile', 'Minimum value'),
                                'type' => 'text',
                                'class' => 'form-control',
                            ],
                        ]
        ]]);
    }

    /**
     * Saves this Profile Field Type
     */
    public function save()
    {
        $columnName = $this->profileField->internal_name;
        if (!\an602\modules\user\models\Profile::columnExists($columnName)) {
            $query = Yii::$app->db->getQueryBuilder()->addColumn(\an602\modules\user\models\Profile::tableName(), $columnName, 'INT');
            Yii::$app->db->createCommand($query)->execute();
        }

        return parent::save();
    }

    /**
     * Returns the Field Rules, to validate users input
     *
     * @param type $rules
     * @return type
     */
    public function getFieldRules($rules = [])
    {

        $rules[] = [$this->profileField->internal_name, 'integer'];

        if ($this->maxValue) {
            $rules[] = [$this->profileField->internal_name, 'integer', 'max' => $this->maxValue];
        }

        if ($this->minValue) {
            $rules[] = [$this->profileField->internal_name, 'integer', 'min' => $this->minValue];
        }

        return parent::getFieldRules($rules);
    }

}

?>
