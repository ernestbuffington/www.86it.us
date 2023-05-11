<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\components;

use Yii;
use yii\base\InvalidArgumentException;
use yii\base\InvalidConfigException;
use yii\helpers\FileHelper;
use yii\web\AssetBundle;
use an602\assets\AppAsset;
use an602\assets\CoreBundleAsset;

/**
 * AssetManager
 *
 * @inheritdoc
 * @author Luke
 */
class AssetManager extends \yii\web\AssetManager
{
    private $_published = [];

    /**
     * @var bool if true will prevent `defer` on all asset bundle scripts
     * @since 1.5
     */
    public $preventDefer = false;

    /**
     * Clears all currently published assets
     */
    public function clear()
    {
        if ($this->basePath == '') {
            return;
        }

        foreach (scandir($this->basePath) as $file) {
            if (substr($file, 0, 1) === '.') {
                continue;
            }
            FileHelper::removeDirectory($this->basePath . DIRECTORY_SEPARATOR . $file);
        }
    }

    /**
     * @inheritDoc
     *
     * Adds defer support for non an602 AssetBundles by $defer property and adds dependency to [[CoreBundleAsset]]
     *
     * @param string $name
     * @param array $config
     * @param bool $publish
     * @return AssetBundle
     * @throws InvalidConfigException
     * @since 1.5
     */
    protected function loadBundle($name, $config = [], $publish = true)
    {
        $bundle = parent::loadBundle($name, $config, $publish);
        $bundleClass = get_class($bundle);

        if($bundleClass !== AppAsset::class
           && !in_array($bundleClass, AppAsset::STATIC_DEPENDS)
           && !in_array($bundleClass, CoreBundleAsset::STATIC_DEPENDS)
           && !is_subclass_of($bundleClass, assets\AssetBundle::class)) {

            // Force dependency to CoreBundleAsset
            array_unshift($bundle->depends, CoreBundleAsset::class);

            // Allows to add defer to non an602 AssetBundles
            if(property_exists($bundle,'defer') && $bundle->defer) {
                $bundle->jsOptions['defer'] = 'defer';
            }
        }

        if($this->preventDefer && isset($bundle->jsOptions['defer'])) {
            unset($bundle->jsOptions['defer']);
        }

        return $bundle;
    }

    public function forcePublish(AssetBundle $bundle, $options = [])
    {
        $options['forceCopy'] = true;

        if ($bundle->sourcePath !== null && !isset($bundle->basePath, $bundle->baseUrl)) {
            $path = Yii::getAlias($bundle->sourcePath);

            if (!is_string($path) || ($src = realpath($path)) === false) {
                throw new InvalidArgumentException("The file or directory to be published does not exist: $path");
            }

            if (is_file($src)) {
                return $this->publishFile($src);
            } else {
                return $this->publishDirectory($src, $options);
            }
        } else {
            $bundle->publish($this);
        }
    }
}
