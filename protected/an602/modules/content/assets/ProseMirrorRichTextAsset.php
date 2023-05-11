<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2018 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 *
 */

namespace an602\modules\content\assets;

use an602\assets\ProsemirrorEditorAsset;
use an602\components\assets\AssetBundle;
/**
 * Asset for core content resources.
 *
 * @since 1.3
 * @author buddha
 */
class ProseMirrorRichTextAsset extends AssetBundle
{
     /**
     * @inheritdoc
     */
    public $sourcePath = '@content/resources';

     /**
     * @inheritdoc
     */
    public $js = [
        'js/an602.ui.richtext.prosemirror.js'
    ];

     /**
     * @inheritdoc
     */
    public $depends = [
        ProsemirrorEditorAsset::class
    ];

}
