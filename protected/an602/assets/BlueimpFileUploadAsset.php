<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\assets;

use an602\components\assets\AssetBundle;

/**
 * jQery Blueimp File Upload
 *
 * @author luke
 */
class BlueimpFileUploadAsset extends AssetBundle
{

    /**
     * @inheritdoc
     */
    public $sourcePath = '@npm/blueimp-file-upload/js';

    /**
     * @inheritdoc
     */
    public $js = [
        'jquery.fileupload.js',
        'jquery.iframe-transport.js',
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        JqueryWidgetAsset::class
    ];

    /**
     * @inheritdoc
     */
    public $publishOptions = [
        'only' => [
            'jquery.fileupload.js',
            'jquery.iframe-transport.js',
        ]
    ];

}
