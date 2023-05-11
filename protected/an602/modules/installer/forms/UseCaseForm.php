<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2015 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\installer\forms;

use Yii;

/**
 * Use Case Form
 *
 * @since 0.5
 */
class UseCaseForm extends \yii\base\Model
{

    /**
     * @var string use case
     */
    public $useCase;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['useCase'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'useCase' => Yii::t('InstallerModule.base', 'I want to use an602 for:'),
        ];
    }

}
