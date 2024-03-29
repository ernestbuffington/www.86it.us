<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2021 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\marketplace\widgets;

use an602\components\Widget;
use an602\modules\marketplace\models\Licence;
use an602\modules\marketplace\models\Module;
use an602\modules\marketplace\Module as MarketplaceModule;
use an602\modules\ui\icon\widgets\Icon;
use an602\widgets\Button;
use Yii;

/**
 * ModuleInstallActionButtons shows actions for not installed module
 *
 * @since 1.11
 * @author Luke
 */
class ModuleInstallActionButtons extends Widget
{

    /**
     * @var Module
     */
    public $module;

    /**
     * @var string Template for buttons
     */
    public $template = '<div class="card-footer text-right">{buttons}</div>';

    /**
     * @inheritdoc
     */
    public function run()
    {
        $html = '';

        if (!isset($this->module->latestCompatibleVersion) || $this->module->isInstalled()) {
            return '';
        }

        /** @var \an602\modules\marketplace\Module $marketplaceModule */
        $marketplaceModule = Yii::$app->getModule('marketplace');
        $licence = $marketplaceModule->getLicence();

        if ($this->module->isProOnly() && $licence->type === Licence::LICENCE_TYPE_CE) {
            $html .= Button::primary(Icon::get('info-circle') . '&nbsp;&nbsp;' . Yii::t('MarketplaceModule.base', 'Learn more'))
                ->link('https://www.an602.com/en/professional-edition')
                ->options(['target' => '_blank'])
                ->sm()
                ->loader(false);
        } elseif (!empty($this->module->price_request_quote) && !$this->module->purchased) {
            $html .= Button::primary(Yii::t('MarketplaceModule.base', 'Buy'))
                ->link($this->module->checkoutUrl)
                ->sm()
                ->options(['target' => '_blank'])
                ->loader(false);
        } elseif (!empty($this->module->price_eur) && !$this->module->purchased) {
            $html .= Button::primary(Yii::t('MarketplaceModule.base', 'Buy (%price%)', ['%price%' => $this->module->price_eur . '&euro;']))
                ->link($this->module->checkoutUrl)
                ->sm()
                ->options(['target' => '_blank'])
                ->loader(false);
        } else {
            $html .= Button::primary(Yii::t('MarketplaceModule.base', 'Install'))
                ->link(['/marketplace/browse/install', 'moduleId' => $this->module->id])
                ->sm()
                ->options([
                    'data-method' => 'POST',
                    'data-loader' => 'modal',
                    'data-message' => Yii::t('MarketplaceModule.base', 'Installing module...'),
                ]);
        }

        if (trim($html) === '') {
            return '';
        }

        return str_replace('{buttons}', $html, $this->template);
    }

}
