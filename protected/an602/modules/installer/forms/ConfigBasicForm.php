<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2015 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\installer\forms;

use Yii;

/**
 * ConfigBasicForm holds basic application settings.
 *
 * @since 0.5
 */
class ConfigBasicForm extends \yii\base\Model
{

    /**
     * @var string name of installation
     */
    public $name;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name', 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('InstallerModule.base', 'Name of your network'),
        ];
    }

}
