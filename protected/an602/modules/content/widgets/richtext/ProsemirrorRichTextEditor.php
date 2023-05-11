<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 *
 */

namespace an602\modules\content\widgets\richtext;


use an602\modules\content\assets\ProseMirrorRichTextAsset;
use an602\modules\file\widgets\UploadInput;

/**
 * Rich text editor implementation for the ProsemirrorRichText.
 *
 * @author Julian Harrer <julian.harrer@an602.com>
 * @see ProsemirrorRichText for a more detailed description of supported plugins and features.
 * @since 1.3
 */
class ProsemirrorRichTextEditor extends AbstractRichTextEditor
{
    const MENU_CLASS_FOCUS = 'focusMenu';
    const MENU_CLASS_PLAIN = 'plainMenu';

    /**
     * @inheritdoc
     */
    public $jsWidget = 'ui.richtext.prosemirror.RichTextEditor';

    /**
     * @var string defines the editor style, which will be added as class attribute
     */
    public $menuClass;

    public static  $renderer = [
        'class' => ProsemirrorRichText::class
    ];

    public function init()
    {
        if($this->layout === static::LAYOUT_BLOCK) {
            $this->exclude[] = 'resizeNav';
            $this->menuClass = static::MENU_CLASS_PLAIN;
        } else {
            $this->menuClass = static::MENU_CLASS_FOCUS;
        }

        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function getAttributes()
    {
        return [
            'class' => 'ProsemirrorEditor '.$this->menuClass
        ];
    }

    /**
     * Prepends an upload input form element to the rich text editor used by the upload editor plugin.
     */
    public function prepend()
    {
        return UploadInput::widget([
            'id' => $this->getId(true).'-file-upload',
            'hideInStream' => true
        ]);
    }
}
