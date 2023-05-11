<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2021 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\content\widgets;

use an602\components\Module;
use an602\components\Widget;
use an602\modules\content\components\ContentContainerActiveRecord;
use an602\modules\space\models\Space;
use an602\widgets\Button;
use Yii;

/**
 * ModuleActionsButton shows actions for module of Content Container
 *
 * @since 1.11
 * @author Luke
 */
class ModuleActionButtons extends Widget
{

    /**
     * @var Module
     */
    public $module;

    /**
     * @var ContentContainerActiveRecord
     */
    public $contentContainer;

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

        if ($this->module->getContentContainerConfigUrl($this->contentContainer) &&
            $this->contentContainer->moduleManager->isEnabled($this->module->id)) {
            $html .= Button::asLink(Yii::t('ContentModule.base', 'Configure'), $this->module->getContentContainerConfigUrl($this->contentContainer))
                ->cssClass('btn btn-sm btn-info configure-module-' . $this->module->id);
        }

        if ($this->contentContainer->moduleManager->canDisable($this->module->id)) {
            $html .= Button::asLink('<span class="glyphicon glyphicon-ok"></span>&nbsp;&nbsp;' . Yii::t('ContentModule.base', 'Activated'), '#')
                ->cssClass('btn btn-sm btn-info active disable disable-module-' . $this->module->id)
                ->style($this->contentContainer->moduleManager->isEnabled($this->module->id) ? '' : 'display:none')
                ->options([
                    'data-action-click' => 'content.container.disableModule',
                    'data-action-url' => $this->getDisableUrl(),
                    'data-reload' => '1',
                    'data-action-confirm' => $this->getDisableConfirmationText(),
                    'data-ui-loader' => 1,
                ]);
        }

        $html .= Button::asLink(Yii::t('ContentModule.base', 'Enable'), '#')
            ->cssClass('btn btn-sm btn-info enable enable-module-' . $this->module->id)
            ->style($this->contentContainer->moduleManager->isEnabled($this->module->id) ? 'display:none' : '')
            ->options([
                'data-action-click' => 'content.container.enableModule',
                'data-action-url' => $this->getEnableUrl(),
                'data-reload' => '1',
                'data-ui-loader' => 1,
            ]);

        if (trim($html) === '') {
            return '';
        }

        return str_replace('{buttons}', $html, $this->template);
    }

    private function isSpace(): bool
    {
        return $this->contentContainer instanceof Space;
    }

    private function getDisableUrl(): string
    {
        $route = $this->isSpace() ? '/space/manage/module/disable' : '/user/account/disable-module';
        return $this->contentContainer->createUrl($route, ['moduleId' => $this->module->id]);
    }

    private function getDisableConfirmationText(): string
    {
        return $this->isSpace()
            ? Yii::t('ContentModule.manage', 'Are you sure? *ALL* module data for this space will be deleted!')
            : Yii::t('ContentModule.manage', 'Are you really sure? *ALL* module data for your profile will be deleted!');
    }

    private function getEnableUrl(): string
    {
        $route = $this->isSpace() ? '/space/manage/module/enable' : '/user/account/enable-module';
        return $this->contentContainer->createUrl($route, ['moduleId' => $this->module->id]);
    }

}
