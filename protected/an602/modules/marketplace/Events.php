<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2019 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\marketplace;

use an602\components\Module as CoreModule;
use an602\components\OnlineModule;
use an602\modules\admin\events\ModulesEvent;
use an602\modules\admin\libs\an602API;
use an602\modules\admin\widgets\ModuleControls;
use an602\modules\admin\widgets\ModuleFilters;
use an602\modules\admin\widgets\Modules;
use an602\modules\marketplace\models\Module as ModelModule;
use yii\helpers\Url;
use an602\modules\ui\icon\widgets\Icon;
use an602\modules\ui\menu\MenuLink;
use an602\widgets\Button;
use Yii;
use yii\base\BaseObject;
use yii\base\Event;

class Events extends BaseObject
{

    /**
     * On console application initialization
     *
     * @param Event $event
     */
    public static function onConsoleApplicationInit($event)
    {
        if (!self::getEnabledMarketplaceModule()) {
            return;
        }

        $application = $event->sender;
        $application->controllerMap['module'] = commands\MarketplaceController::class;
    }

    public static function onHourlyCron($event)
    {
        Yii::$app->queue->push(new jobs\PeActiveCheckJob());
        Yii::$app->queue->push(new jobs\ModuleCleanupsJob());
    }

    private static function getEnabledMarketplaceModule(): ?Module
    {
        /* @var Module $marketplaceModule */
        $marketplaceModule = Yii::$app->getModule('marketplace');

        return $marketplaceModule->enabled ? $marketplaceModule : null;
    }

    public static function onAdminModuleFiltersInit($event)
    {
        if (!($marketplaceModule = self::getEnabledMarketplaceModule())) {
            return;
        }

        /* @var ModuleFilters $moduleFilters */
        $moduleFilters = $event->sender;

        $marketplaceModule->onlineModuleManager->getModules();
        $categories = $marketplaceModule->onlineModuleManager->getCategories();
        if (!empty($categories)) {
            $moduleFilters->addFilter('categoryId', [
                'title' => Yii::t('MarketplaceModule.base', 'Categories'),
                'type' => 'dropdown',
                'options' => $categories,
                'wrapperClass' => 'col-md-3',
                'sortOrder' => 200,
            ]);
        }

        $moduleFilters->addFilter('tags', [
            'title' => Yii::t('MarketplaceModule.base', 'Tags'),
            'type' => 'tags',
            'tags' => [
                '' => Yii::t('MarketplaceModule.base', 'All'),
                'installed' => Yii::t('MarketplaceModule.base', 'Installed'),
                'not_installed' => Yii::t('MarketplaceModule.base', 'Not Installed'),
                'professional' => Yii::t('MarketplaceModule.base', 'Professional Edition'),
                'featured' => Yii::t('MarketplaceModule.base', 'Featured'),
                'official' => Yii::t('MarketplaceModule.base', 'Official'),
                'partner' => Yii::t('MarketplaceModule.base', 'Partner'),
                'new' => Yii::t('MarketplaceModule.base', 'New'),
            ],
            'wrapperClass' => 'col-md-12 form-search-filter-tags',
            'sortOrder' => 20000,
        ]);
    }

    public static function onAdminModuleFiltersAfterRun($event)
    {
        if (!self::getEnabledMarketplaceModule()) {
            return;
        }

        $latestVersion = an602API::getLatestan602Version();
        if (!$latestVersion) {
            return;
        }

        if (version_compare($latestVersion, Yii::$app->version, '>')) {
            $updateUrl = 'https://docs.an602.86it.us/docs/admin/updating/';
            if (Yii::$app->hasModule('updater')) {
                $updateUrl = Url::to(['/updater/update']);
            }

            $info = [
                'class' => 'directory-filters-footer-warning',
                'icon' => 'info-circle',
                'info' => Yii::t('MarketplaceModule.base', 'A new update is available (an602 %version%)!', ['%version%' => $latestVersion]),
                'link' => Button::asLink(Yii::t('MarketplaceModule.base', 'Learn more'), $updateUrl)
                    ->cssClass('btn btn-primary'),
            ];
        } else {
            $info = [
                'class' => 'directory-filters-footer-info',
                'icon' => 'check-circle',
                'info' => Yii::t('MarketplaceModule.base', 'Your an602 installation is up to date!'),
                'link' => Button::asLink('https://www.an602.com', 'https://www.an602.com')
                    ->cssClass('btn btn-info'),
            ];
        }

        /* @var ModuleFilters $moduleFilters */
        $moduleFilters = $event->sender;
        $event->result .= $moduleFilters->render('@an602/modules/marketplace/widgets/views/moduleUpdateInfo', $info);
    }

    public static function onAdminModulesInit($event)
    {
        if (!($marketplaceModule = self::getEnabledMarketplaceModule())) {
            return;
        }

        /* @var Modules $modulesWidget */
        $modulesWidget = $event->sender;

        $updateModules = $marketplaceModule->onlineModuleManager->getAvailableUpdateModules();
        if ($updateModulesCount = count($updateModules)) {
            $updateAllButton = Button::primary(Yii::t('MarketplaceModule.base', 'Update all'))
                ->options([
                    'data-stop-title' => Icon::get('pause') . ' &nbsp; ' . Yii::t('MarketplaceModule.base', 'Stop updating'),
                    'data-stop-class' => 'btn btn-warning pull-right',
                ])
                ->action('marketplace.updateAll')
                ->loader(false)
                ->cssClass('active pull-right');

            $modulesWidget->addGroup('availableUpdates', [
                'title' => Yii::t('MarketplaceModule.base', 'Available Updates'),
                'modules' => $updateModules,
                'count' => $updateModulesCount,
                'view' => '@an602/modules/marketplace/widgets/views/moduleUpdateCard',
                'groupTemplate' => '<div class="container-module-updates">' . $updateAllButton . '{group}</div>',
                'moduleTemplate' => '<div class="card card-module col-lg-2 col-md-3 col-sm-4 col-xs-6">{card}</div>',
                'sortOrder' => 10,
            ]);
        }

        if (!$marketplaceModule->isFilteredBySingleTag('installed')) {
            $onlineModules = $marketplaceModule->onlineModuleManager->getNotInstalledModules();
            if ($onlineModulesCount = count($onlineModules)) {
                $modulesWidget->addGroup('notInstalled', [
                    'title' => Yii::t('AdminModule.modules', 'Not Installed'),
                    'modules' => Yii::$app->moduleManager->filterModules($onlineModules),
                    'count' => $onlineModulesCount,
                    'view' => '@an602/modules/marketplace/widgets/views/moduleInstallCard',
                    'sortOrder' => 200,
                ]);
            }
        }
    }

    public static function onAdminModuleManagerAfterFilterModules(ModulesEvent $event)
    {
        if (!self::getEnabledMarketplaceModule()) {
            return;
        }

        if (!is_array($event->modules)) {
            return;
        }

        foreach ($event->modules as $m => $module) {
            if (!self::isFilteredModule($module)) {
                unset($event->modules[$m]);
            }
        }
    }

    /**
     * @param CoreModule|ModelModule $module
     * @return bool
     */
    private static function isFilteredModule($module): bool
    {
        return self::isFilteredModuleByCategory($module) &&
            self::isFilteredModuleByTags($module);
    }

    /**
     * @param CoreModule|ModelModule $module
     * @return bool
     */
    private static function isFilteredModuleByCategory($module): bool
    {
        $categoryId = Yii::$app->request->get('categoryId', null);

        if (empty($categoryId)) {
            return true;
        }

        $moduleCategories = (new OnlineModule(['module' => $module]))->categories;

        return empty($moduleCategories) ? false : in_array($categoryId, $moduleCategories);
    }

    /**
     * @param CoreModule|ModelModule $module
     * @return bool
     */
    private static function isFilteredModuleByTags($module): bool
    {
        $tags = Yii::$app->request->get('tags', null);

        if (empty($tags)) {
            return true;
        }

        $tags = explode(',', $tags);

        $onlineModule = new OnlineModule(['module' => $module]);

        $searchInstalled = in_array('installed', $tags);
        $searchNotInstalled = in_array('not_installed', $tags);
        if ($searchInstalled && $searchNotInstalled && count($tags) === 2) {
            // No need to filter when only 2 tags "Installed" and "Not Installed" are selected
            return true;
        }
        if ($searchInstalled && !$searchNotInstalled && !$onlineModule->isInstalled) {
            // Exclude all NOT Installed modules when requested only Installed modules
            return false;
        }
        if (!$searchInstalled && $searchNotInstalled && $onlineModule->isInstalled) {
            // Exclude all Installed modules when requested only NOT Installed modules
            return false;
        }
        if (($searchInstalled || $searchNotInstalled) && count($tags) === 1) {
            // No need to next filter when only 1 tag "Installed" or "Not Installed" is selected
            return true;
        }

        foreach ($tags as $tag) {
            switch ($tag) {
                case 'professional':
                    if ($onlineModule->isProOnly) {
                        return true;
                    }
                    break;
                case 'featured':
                    if ($onlineModule->isFeatured) {
                        return true;
                    }
                    break;
                case 'official':
                    if (!$onlineModule->isThirdParty) {
                        return true;
                    }
                    break;
                case 'partner':
                    if ($onlineModule->isPartner) {
                        return true;
                    }
                    break;
                case 'new':
                    // TODO: Filter by new status
                    break;
            }
        }

        return false;
    }

    public static function onAdminModuleControlsInit($event)
    {
        if (!self::getEnabledMarketplaceModule()) {
            return;
        }

        /* @var ModuleControls $moduleControls */
        $moduleControls = $event->sender;

        $module = $moduleControls->module;

        if (!($module instanceof ModelModule)) {
            return;
        }

        /** @var \an602\modules\marketplace\models\Module $module */

        if ($module->isNonFree) {
            $moduleControls->addEntry(new MenuLink([
                'id' => 'marketplace-licence-key',
                'label' => Yii::t('MarketplaceModule.base', 'Add Licence Key'),
                'url' => ['/marketplace/purchase'],
                'htmlOptions' => ['data-target' => '#globalModal'],
                'icon' => 'key',
                'sortOrder' => 1000,
            ]));
        }

        if ($module->isThirdParty) {
            $moduleControls->addEntry(new MenuLink([
                'id' => 'marketplace-third-party',
                'label' => Yii::t('MarketplaceModule.base', 'Third-party')
                    . ($module->isCommunity ? ' - ' . Yii::t('MarketplaceModule.base', 'Community') : ''),
                'url' => ['/marketplace/browse/thirdparty-disclaimer'],
                'htmlOptions' => ['data-target' => '#globalModal'],
                'icon' => 'info-circle',
                'sortOrder' => 1100,
            ]));
        }
    }
}
