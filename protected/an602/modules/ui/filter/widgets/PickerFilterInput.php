<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2018 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 *
 */

namespace an602\modules\ui\filter\widgets;

use an602\components\ActiveRecord;
use an602\modules\ui\form\widgets\BasePicker;
use Yii;
use yii\helpers\ArrayHelper;

class PickerFilterInput extends FilterInput
{
    /**
     * @inheritdoc
     */
    public $view = 'pickerInput';

    /**
     * @inheritdoc
     */
    public $type = 'picker';

    public $pickerOptions = [];

    public $picker = BasePicker::class;

    /**
     * @var string data-action-click handler of the input event
     */
    public $changeAction = 'parent.inputChange';

    /**
     * @inheritdoc
     */
    protected function initFromRequest()
    {
        $filters = Yii::$app->request->get($this->category);
        if (!is_array($filters) || empty($filters)) {
            return;
        }

        if ($pickerItemClass = $this->getPickerItemClass()) {
            $this->pickerOptions['selection'] = $pickerItemClass::find()
                ->where(['IN', $this->getPicker()->itemKey, $filters])
                ->all();
        } else if($pickerItems = $this->getPickerItems()) {
            $this->pickerOptions['selection'] = array_intersect($filters, array_keys($pickerItems));
        }
    }

    protected function getPicker(): BasePicker
    {
        return new $this->picker;
    }

    /**
     * @return ActiveRecord|string|null
     */
    protected function getPickerItemClass()
    {
        $picker = $this->getPicker();
        return $picker->itemClass ?: null;
    }

    /**
     * @return array|null
     */
    protected function getPickerItems()
    {
        $picker = $this->getPicker();
        return empty($picker->items) || !is_array($picker->items) ? null : $picker->items;
    }

    /**
     * @inheritdoc
     */
    public function prepareOptions()
    {
        parent::prepareOptions();

        $this->options['data-action-change'] = $this->changeAction;
        $this->pickerOptions['options'] = $this->options;

    }

    public function getWidgetOptions()
    {

        return ArrayHelper::merge(parent::getWidgetOptions(), ['pickerClass' => $this->picker, 'pickerOptions' => $this->pickerOptions]);
    }
}
