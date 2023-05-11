<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\file\widgets;

use yii\helpers\ArrayHelper;
use an602\libs\Html;

/**
 * FileHandlerButtonWidget shows a dropdown with different file handlers
 *
 * @since 1.2
 * @author Luke
 */
class FileHandlerButtonDropdown extends \an602\components\Widget
{

    /**
     * @var string the primary button html code, if not set the first handler will be used
     */
    public $primaryButton;

    /**
     * @var string the default css bootstrap button class
     */
    public $cssButtonClass = 'btn-success';

    /**
     * @var \an602\modules\file\handler\BaseFileHandler[] the handlers to show
     */
    public $handlers;
    
    /**
     * @var boolean if true the dropdown-menu will be assigned with an dropdown-menu-right class.
     */
    public $pullRight = false;

    /**
     * @inheritdoc
     */
    public function run()
    {

        if (!$this->primaryButton && count($this->handlers) === 0) {
            return;
        }

        $output = Html::beginTag('div', ['class' => 'btn-group']);

        if (!$this->primaryButton) {
            $firstButton = array_shift($this->handlers)->getLinkAttributes();
            Html::addCssClass($firstButton, ['btn', $this->cssButtonClass]);
            $output .= $this->renderLink($firstButton);
        } else {
            $output .= $this->primaryButton;
        }

        if (count($this->handlers) !== 0) {
            $output .= '<button type="button" class="btn ' . $this->cssButtonClass . ' dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button>';
            
            $cssClass = ($this->pullRight) ? 'dropdown-menu dropdown-menu-right' : 'dropdown-menu';
            
            $output .= Html::beginTag('ul', ['class' => $cssClass]);
            foreach ($this->handlers as $handler) {
                $output .= Html::beginTag('li');
                $output .= $this->renderLink($handler->getLinkAttributes());
                $output .= Html::endTag('li');
            }
            $output .= Html::endTag('ul');
        }
        $output .= Html::endTag('div');

        return $output;
    }

    /**
     * Renders the file handle link
     * 
     * @param array $options the HTML options
     * @return string the rendered HTML tag
     */
    protected function renderLink($options)
    {
        
        $options['data-action-process'] = 'file-handler';
        
        $label = ArrayHelper::remove($options, 'label', 'Label');

        if (isset($options['url'])) {
            $url = ArrayHelper::remove($options, 'url', '#');
            $options['href'] = $url;
        }

        return Html::tag('a', $label, $options);
    }

}
