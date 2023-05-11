<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2019 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\marketplace;

use an602\components\Module as BaseModule;
use an602\modules\marketplace\components\an602ApiClient;
use an602\modules\marketplace\components\LicenceManager;
use an602\modules\marketplace\models\Licence;
use an602\modules\marketplace\components\OnlineModuleManager;
use Yii;

/**
 * The Marketplace modules contains all the capabilities to interact with the offical an602 marketplace.
 * The core functions are the ability to easily install or update modules from the remote module directory.
 *
 * @property-read Licence $licence
 * @property OnlineModuleManager $onlineModuleManager
 * @since 1.4
 */
class Module extends BaseModule
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'an602\modules\marketplace\controllers';

    /**
     * @inheritdoc
     */
    public $isCoreModule = true;

    /**
     * @var string path to store marketplace modules
     * If the param 'moduleMarketplacePath' is set this value will be used.
     * Note: The path must also be added to the module autoloader `Yii::$app->params['moduleAutoloadPaths']`.
     */
    public $modulesPath = '@app/modules';

    /**
     * @var bool
     */
    public $enabled = true;

    /**
     * @var string download path for marketplace modules
     */
    public $modulesDownloadPath = '@runtime/module_downloads';

    /**
     * @var bool
     */
    public $hideLegacyModules = true;

    /**
     * @since 1.8
     * @var array A list of module ids that cannot be installed.
     */
    public $moduleBlacklist = [];

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return Yii::t('MarketplaceModule.base', 'Marketplace');
    }

    private $_onlineModuleManager = null;

    private $_an602Api = null;

    /**
     * @inheritDoc
     */
    public function init()
    {
        parent::init();

        if (Yii::$app->params['an602']['apiEnabled'] !== true) {
            $this->enabled = false;
        }

        if (!empty(Yii::$app->params['moduleMarketplacePath'])) {
            $this->modulesPath = Yii::$app->params['moduleMarketplacePath'];
        }
    }

    /**
     * @return OnlineModuleManager
     */
    public function getOnlineModuleManager()
    {
        if ($this->_onlineModuleManager === null) {
            $this->_onlineModuleManager = new OnlineModuleManager();
        }

        return $this->_onlineModuleManager;
    }


    /**
     * Returns the currently active licence object
     *
     * @return Licence
     */
    public function getLicence()
    {
        return LicenceManager::get();
    }

    /**
     * Returns the public an602 API (Marketplace, Updater & Co)
     *
     * @return an602ApiClient
     */
    public function getan602Api()
    {
        if ($this->_an602Api === null) {
            $this->_an602Api = new an602ApiClient();
        }

        return $this->_an602Api;
    }

    /**
     * Check if the modules list is filtered by single tag
     *
     * @param string $tag
     * @return bool
     */
    public function isFilteredBySingleTag(string $tag): bool
    {
        $tags = Yii::$app->request->get('tags', null);

        if (empty($tags)) {
            return false;
        }

        $tags = explode(',', $tags);

        return count($tags) === 1 && $tags[0] == $tag;
    }
}
