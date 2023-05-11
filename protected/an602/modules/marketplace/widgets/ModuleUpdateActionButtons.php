<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2021 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\marketplace\widgets;

use an602\components\Widget;
use an602\modules\marketplace\models\Module;
use an602\widgets\Button;
use Yii;

/**
 * ModuleInstallActionButtons shows actions for module with available update
 * 
 * @since 1.11
 * @author Luke
 */
class ModuleUpdateActionButtons extends Widget
{

    /**
     * @var Module
     */
    public $module;

    /**
     * @var string Template for buttons
     */
    public $template = '<div class="card-footer">{buttons}</div>';

    /**
     * @inheritdoc
     */
    public function run()
    {
        $html = '';

        if (!isset($this->module->latestCompatibleVersion) || !$this->module->isInstalled()) {
            return $html;
        }

        $html .= Button::asLink(Yii::t('MarketplaceModule.base', 'Update'), ['/marketplace/update/install', 'moduleId' => $this->module->id])
            ->cssClass('btn btn-xs btn-info active')
            ->options(['data-action-click' => 'marketplace.update']);

        $html .= Button::asLink(Yii::t('MarketplaceModule.base', 'Changelog'), $this->module->marketplaceUrl . '/changelog')
            ->cssClass('btn btn-xs btn-info')
            ->options(['target' => '_blank']);

        return str_replace('{buttons}', $html, $this->template);
    }

}
