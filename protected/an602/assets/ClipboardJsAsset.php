<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\assets;

use an602\components\assets\AssetBundle;

/**
 * Clipboard JS
 *
 * @author luke
 */
class ClipboardJsAsset extends AssetBundle
{

    /**
     * @inheritdoc
     */
    public $sourcePath = '@npm/clipboard-polyfill/dist/main';

    /**
     * @inheritdoc
     */
    public $js = ['clipboard-polyfill.js'];

    public $publishOptions = [
        'only' => ['clipboard-polyfill.js', 'clipboard-polyfill.js.map']
    ];

}
