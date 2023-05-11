<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2018 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\ui\view\components;

use an602\libs\BaseSettingsManager;
use an602\modules\ui\Module;
use an602\modules\ui\view\helpers\ThemeHelper;

use Yii;
use yii\base\Component;


/**
 * ThemeVariables provides access to LESS variables of a given [[Theme]].
 * The variables will be stored in the application SettingManager for fast access.
 *
 * @since 1.3
 * @package an602\modules\ui\view\components
 */
class ThemeVariables extends Component
{
    const SETTING_PREFIX = 'theme.var.';

    /**
     * @var Theme
     */
    public $theme;

    /**
     * @var Module
     */
    public $module;

    /**
     * @var boolean
     */
    private $settingsLoaded = false;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->module = Yii::$app;
        parent::init();
    }

    /**
     * returns a variable by given key
     *
     * @param $key
     * @param $default
     * @return string|null
     */
    public function get($key, $default = null)
    {
        if (!BaseSettingsManager::isDatabaseInstalled()) {
            return null;
        }

        $this->ensureLoaded();

        return $this->module->settings->get(
            $this->getSettingKey($key),
            $default
        );
    }

    /**
     * Flushes stored variables from settings manager
     */
    public function flushCache()
    {
        $this->module->settings->deleteAll($this->getSettingPrefix());
    }


    /**
     * @return string a unique setting key prefix for this theme
     */
    protected function getSettingPrefix()
    {
        return static::SETTING_PREFIX . $this->theme->name . '.';
    }

    /**
     * Converts a theme variable key into a prefixed settings key.
     * The prefix is necessary to separate the theme variables
     *
     * @param $key
     * @return string
     */
    protected function getSettingKey($key)
    {
        return $this->getSettingPrefix() . $key;
    }

    /**
     * Ensures that the settings manager was populated with
     * the theme variables, if not the variables will be loaded into
     * the settings manager.
     *
     * Do not run this method during 'init' to avoid storing variables
     * of all available themes!
     */
    protected function ensureLoaded()
    {
        if (!$this->settingsLoaded) {
            if (empty($this->module->settings->get($this->getSettingKey('primary')))) {
                $this->storeVariables();
            }
            $this->settingsLoaded = true;
        }
    }

    /**
     * Rewrites theme variables to settings (cache)
     */
    protected function storeVariables()
    {
        $this->flushCache();

        foreach (ThemeHelper::getAllVariables($this->theme) as $key => $val) {
            $this->module->settings->set(
                $this->getSettingKey($key),
                $val
            );
        }
    }

}
