<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2016 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\widgets;

use yii\helpers\Html;
use yii\web\JsExpression;

/**
 * AjaxLinkPager
 * 
 * @inheritdoc
 * @author luke
 */
class AjaxLinkPager extends \an602\widgets\LinkPager
{

    /**
     * Js Expression which is called before Ajax request is sent
     * 
     * @var string
     */
    public $jsBeforeSend = 'function(){ setModalLoader(); }';

    /**
     * Success Javascript Expression
     * 
     * @var string 
     */
    public $jsSuccess = 'function(html){ $("#globalModal").html(html); }';

    /**
     * @inheritdoc
     */
    protected function renderPageButton($label, $page, $class, $disabled, $active)
    {
        $options = ['class' => $class === '' ? null : $class];
        if ($active) {
            Html::addCssClass($options, $this->activePageCssClass);
        }
        if ($disabled) {
            Html::addCssClass($options, $this->disabledPageCssClass);

            return Html::tag('li', Html::tag('span', $label), $options);
        }
        $linkOptions = $this->linkOptions;
        $linkOptions['data-page'] = $page;

        return Html::tag('li', AjaxButton::widget([
                            'label' => $label,
                            'tag' => 'a',
                            'ajaxOptions' => [
                                'type' => 'POST',
                                'beforeSend' => new JsExpression($this->jsBeforeSend),
                                'success' => new JsExpression($this->jsSuccess),
                                'url' => $this->pagination->createUrl($page),
                            ],
                            'htmlOptions' => $linkOptions]), $options);
    }

}
