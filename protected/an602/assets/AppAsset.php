<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\assets;

use an602\components\assets\WebStaticAssetBundle;
use an602\modules\content\assets\ContentAsset;
use an602\modules\file\assets\FileAsset;
use yii\bootstrap\BootstrapAsset;
use yii\bootstrap\BootstrapPluginAsset;
use yii\jui\JuiAsset;
use yii\validators\ValidationAsset;
use yii\web\JqueryAsset;
use yii\web\View;
use yii\web\YiiAsset;
use yii\widgets\ActiveFormAsset;

/**
 * AppAsset includes an602 core assets to the main layout.
 * This Assetbundle includes some core dependencies and the an602 core api.
 *
 * Note: All CSS/JS files will be compressed and bundled. If you need dynamic
 * css/js loading e.g. based on users locale: see AppDynamicAsset
 */
class AppAsset extends WebStaticAssetBundle
{
    /**
     * @inheritdoc
     */
    public $defer = false;

    /**
     * @inheritdoc
     */
    public $defaultDepends = false;

    /**
     * @inheritdoc
     */
    public $jsPosition = View::POS_HEAD;

    const BUNDLE_NAME = 'app';

    const STATIC_DEPENDS = [
        JqueryAsset::class,
        JuiBootstrapBridgeAsset::class,
        JuiAsset::class,
        YiiAsset::class,
        ActiveFormAsset::class,
        ValidationAsset::class,
        BootstrapAsset::class,
        BootstrapPluginAsset::class,
        BluebirdAsset::class,
        FontAwesomeAsset::class,
        AnimateCssAsset::class, // preload
        OpenSansAsset::class,
        PjaxAsset::class,
        JqueryTimeAgoAsset::class,

        /**
         * Style only assets
         */
        HighlightJsStyleAsset::class,
        NProgressStyleAsset::class,
        Select2StyleAsset::class,
        BlueimpGalleryStyleAsset::class,
        FlatelementsStyleAsset::class,


        /**
         * Polyfills
         */
        IntersectionObserverPolyfillAsset::class,



        /**
         * Core an602 API + commonly required modules
         */
        CoreApiAsset::class,
        ContentAsset::class,
        FileAsset::class,
    ];

    /**
     * @inheritdoc
     */
    public $depends = self::STATIC_DEPENDS;

    /**
     * @inheritdoc
     */
    public $js = [
        'js/desktop-notify-min.js',
        'js/desktop-notify-config.js',
    ];

    /**
     * @inheritdoc
     */
    public static function register($view)
    {
        $instance = parent::register($view);

        AppDynamicAsset::register($view);
        CoreBundleAsset::register($view);

        return $instance;
    }

}
