<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2018 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 *
 */

namespace an602\modules\content\widgets;

use Yii;
use an602\libs\Html;
use an602\modules\content\models\ContentTag;
use an602\modules\ui\form\widgets\JsInputWidget;

class ContentTagDropDown extends JsInputWidget
{
    /**
     * @var string tagClass
     */
    public $tagClass;
    public $query;
    public $contentContainer;
    public $includeGlobal = false;
    public $type = true;
    public $prompt = false;
    public $promptValue = 0;

    public $items;
    private $itemOptions = [];

    public function int()
    {
        parent::init();

        if (!$this->tagClass) {
            $this->tagClass = ContentTag::class;
            // Reset default behavior inf no specific tagClass is given
            if ($this->type === true) {
                $this->type = null;
            }
        }

        if (!$this->none && !$this->noneLabel) {
            $this->noneLabel = Yii::t('ContentModule.base', 'None');
        }
    }

    public function run()
    {
        $items = $this->getItems();

        if (empty($items)) {
            return $this->emptyResult();
        }

        $options = $this->getOptions();
        unset($options['id']);

        if ($this->form && $this->hasModel()) {
            return $this->form->field($this->model, $this->attribute)->dropDownList($items, $options);
        } elseif ($this->hasModel()) {
            return Html::activeDropDownList($this->model, $this->attribute, $items, $options);
        } else {
            return Html::dropDownList($this->name, $this->value, $items, $options);
        }
    }

    public function getAttributes()
    {
        $result = [
            'class' => 'form-control',
            'options' => $this->itemOptions
        ];

        if ($this->prompt) {
            $result['prompt'] = $this->prompt;
        }

        return $result;
    }

    public function getItems()
    {
        if ($this->items) {
            return $this->items;
        }

        if (!$this->query) {
            if ($this->contentContainer) {
                $this->query = call_user_func($this->tagClass .'::findByContainer', $this->contentContainer, $this->includeGlobal);
            } elseif (!empty($this->type)) {
                $type = ($this->type === true) ? $this->tagClass : $this->type;
                $this->query = call_user_func($this->tagClass .'::findByType', [$type]);
            } else {
                $this->query = call_user_func($this->tagClass .'::find');
            }
        }

        $tags = $this->items = $this->query->all();

        $result = [];
        foreach ($tags as $tag) {
            $result[$tag->id] = $tag->name;
            $this->itemOptions[$tag->id] = [
                'data-type-color' => $tag->color
            ];
        }

        return $result;
    }

}
