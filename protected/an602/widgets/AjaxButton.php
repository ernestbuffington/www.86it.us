<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2015 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\widgets;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\Json;
use yii\web\JsExpression;

/**
 * AjaxButton is an replacement for Yii1 CHtml::AjaxButton
 *
 * @author luke
 */
class AjaxButton extends Widget
{

    public $beforeSend;
    public $success;
    public $ajaxOptions = [];
    public $htmlOptions = [];
    public $label = 'Unnamed';
    public $tag = 'button';

    public function init()
    {
        if (!isset($this->htmlOptions['id'])) {
            $this->htmlOptions['id'] = $this->getId();
        }

        if (!isset($this->ajaxOptions['type'])) {
            $this->ajaxOptions['type'] = new JsExpression('$(this).parents("form").attr("method")');
        }

        if (!isset($this->ajaxOptions['url'])) {
            $this->ajaxOptions['url'] = new JsExpression('$(this).parents("form").attr("action")');
        } else {
            $this->ajaxOptions['url'] = Url::to($this->ajaxOptions['url']);
        }

        if (!isset($this->ajaxOptions['data']) && isset($this->ajaxOptions['type'])) {
            $this->ajaxOptions['data'] = new JsExpression("$('#{$this->htmlOptions['id']}').closest('form').serialize()");
        }

        if (isset($this->ajaxOptions['beforeSend']) && !$this->ajaxOptions['beforeSend'] instanceof JsExpression) {
            $this->ajaxOptions['beforeSend'] = new JsExpression($this->ajaxOptions['beforeSend']);
        }

        if (isset($this->ajaxOptions['success']) && !$this->ajaxOptions['success'] instanceof JsExpression) {
            $this->ajaxOptions['success'] = new JsExpression($this->ajaxOptions['success']);
        }
    }

    public function run()
    {
        echo Html::tag($this->tag, $this->label, $this->htmlOptions);

        if (isset($this->htmlOptions['return']) && $this->htmlOptions['return']) {
            $return = 'return true';
        } else {
            $return = 'return false';
        }

        $this->view->registerJs("$('#{$this->htmlOptions['id']}').click(function(evt) {
                $.ajax(" . Json::encode($this->ajaxOptions) . ");
                    {$return};
            });");
    }

}
