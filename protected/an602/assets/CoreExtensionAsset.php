<?php


namespace an602\assets;

use an602\components\assets\WebStaticAssetBundle;

class CoreExtensionAsset extends WebStaticAssetBundle
{
    /**
     * @inheritdoc
     */
    public $defaultDepends = false;

    /**
     * @inheritdoc
     */
    public $js = [

        'js/an602/an602.ui.form.elements.js',
        'js/an602/an602.ui.form.js',
        'js/an602/an602.ui.showMore.js',
        'js/an602/an602.ui.panel.js',
        'js/an602/an602.ui.gallery.js',
        'js/an602/an602.ui.picker.js',
        'js/an602/an602.ui.codemirror.js',
        'js/an602/an602.oembed.js',
        'js/an602/an602.media.Jplayer.js',
        // Note this should stay at last for other click event listeners beeing able to prevent pjax handling (e.g gallery)
        'js/an602/an602.client.pjax.js',
    ];
}
