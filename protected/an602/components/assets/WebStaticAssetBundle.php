<?php


namespace an602\components\assets;

/**
 * Base asset bundle class for @web-static assets residing in `static` directory.
 *
 * @package an602\components\assets
 */
class WebStaticAssetBundle extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $basePath = '@webroot-static';

    /**
     * @inheritdoc
     */
    public $baseUrl = '@web-static';

}
