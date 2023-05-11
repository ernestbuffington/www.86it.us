<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2016 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\user\models\fieldtype;

use an602\modules\user\models\Profile;
use an602\modules\user\models\User;
use Yii;

/**
 * Markdown Profile Field
 * 
 * @since 1.1
 */
class MarkdownEditor extends BaseType
{
    /**
     * @inheritdoc
     */
    public $type = 'markdown';

    /**
     * @inheritdoc
     */
    public function getFormDefinition($definition = [])
    {
        return parent::getFormDefinition([
                    get_class($this) => [
                        'type' => 'form',
                        'title' => Yii::t('UserModule.profile', 'Text area field options'),
                        'elements' => [
                        ]
                    ]]);
    }

    /**
     * @inheritdoc
     */
    public function save()
    {
        $columnName = $this->profileField->internal_name;
        if (!Profile::columnExists($columnName)) {
            $query = Yii::$app->db->getQueryBuilder()->addColumn(Profile::tableName(), $columnName, 'TEXT');
            Yii::$app->db->createCommand($query)->execute();
        }

        return parent::save();
    }

    /**
     * @inheritdoc
     */
    public function getFieldRules($rules = [])
    {
        $rules[] = [$this->profileField->internal_name, 'safe'];
        return parent::getFieldRules($rules);
    }

    /**
     * @inheritdoc
     */
    public function getFieldFormDefinition(User $user = null, array $options = []): array
    {
        return parent::getFieldFormDefinition($user, array_merge([
            'rows' => '3'
        ], $options));
    }

}
?>
