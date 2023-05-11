<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2018 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 *
 */

namespace an602\modules\ui\form\validators;

use an602\modules\ui\form\widgets\IconPicker;
use an602\modules\ui\icon\widgets\Icon;
use Yii;
use yii\validators\Validator;


/**
 * IconValidator validates input from the IconPicker
 *
 * @since 1.3
 * @see IconPicker
 */
class IconValidator extends Validator
{

    /**
     * @param \yii\base\Model $model
     * @param string $attribute
     */
    public function validateAttribute($model, $attribute)
    {
        $iconPicker = new IconPicker(['model' => $model, 'attribute' => $attribute]);

        if (!in_array($model->$attribute, Icon::$names)) {
            $this->addError($model, $attribute, Yii::t('UiModule.form', 'Invalid icon.'));
        }
    }

}
