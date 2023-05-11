<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2015 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\installer\forms;

use Yii;

/**
 * Sample Data Form
 *
 * @since 0.5
 */
class SampleDataForm extends \yii\base\Model
{

    /**
     * @var boolean create sample data
     */
    public $sampleData;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sampleData'], 'boolean'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sampleData' => Yii::t('InstallerModule.base', 'Set up example content (recommended)'),
        ];
    }

}
