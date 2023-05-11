<?php


namespace an602\modules\ui\form\assets;


use an602\assets\BootstrapMarkdownAsset;
use an602\components\assets\AssetBundle;

/**
 * Class MarkdownFieldAsset
 * @package an602\modules\ui\form\assets
 * @deprecated since 1.5 Use `an602\modules\content\widgets\richtext\RichTextField`
 */
class MarkdownFieldAsset extends AssetBundle
{
    public $sourcePath = '@ui/form/resources';

    public $css = [
        'css/bootstrap-markdown-override.css'
    ];

    public $js = [
        'js/markdownEditor.js',
        'js/an602.ui.markdown.js'
    ];

    public $depends = [
        BootstrapMarkdownAsset::class
    ];
}
