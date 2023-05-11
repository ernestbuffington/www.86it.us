<?php

namespace an602\assets;

use an602\components\assets\WebStaticAssetBundle;
use an602\modules\activity\assets\ActivityAsset;
use an602\modules\comment\assets\CommentAsset;
use an602\modules\content\assets\ContentAsset;
use an602\modules\content\assets\ContentContainerAsset;
use an602\modules\content\assets\ProseMirrorRichTextAsset;
use an602\modules\file\assets\FileAsset;
use an602\modules\like\assets\LikeAsset;
use an602\modules\live\assets\LiveAsset;
use an602\modules\notification\assets\NotificationAsset;
use an602\modules\post\assets\PostAsset;
use an602\modules\space\assets\SpaceAsset;
use an602\modules\space\assets\SpaceChooserAsset;
use an602\modules\stream\assets\StreamAsset;
use an602\modules\topic\assets\TopicAsset;
use an602\modules\ui\filter\assets\FilterAsset;
use an602\modules\user\assets\UserAsset;
use an602\modules\user\assets\UserPickerAsset;

/**
 * This asset bundle contains core script dependencies which should be compatible with defer script loading.
 * In a production build, all scripts will be bundled within `static/js/an602-bundle.js` and deally be loaded with
 * defer script loading.
 *
 * > Note: this class should not depend on any style assets, otherwise an extra an602-bundle.css will be created which
 * will triggers an extra asset request. All core style assets should be part of the `AppAsset` class.
 */
class CoreBundleAsset extends WebStaticAssetBundle
{
    const BUNDLE_NAME = 'defer';

    public $defaultDepends = false;

    const STATIC_DEPENDS = [
        AppAsset::class,
        JqueryHighlightAsset::class,
        JqueryAutosizeAsset::class,
        Select2Asset::class,
        JqueryWidgetAsset::class,
        NProgressAsset::class,
        JqueryNiceScrollAsset::class,
        BlueimpFileUploadAsset::class,
        BlueimpGalleryAsset::class,
        ClipboardJsAsset::class,
        ImagesLoadedAsset::class,
        HighlightJsAsset::class,
        SwipedEventsAssets::class,
        CoreExtensionAsset::class,
        ProsemirrorEditorAsset::class,
        ProseMirrorRichTextAsset::class,
        JqueryCookieAsset::class,
        UserAsset::class,
        LiveAsset::class,
        NotificationAsset::class,
        ContentContainerAsset::class,
        UserPickerAsset::class,
        PostAsset::class,
        SpaceAsset::class,
        TopicAsset::class,
        FilterAsset::class,
        CommentAsset::class,
        LikeAsset::class,
        StreamAsset::class,
        ActivityAsset::class,
        SpaceChooserAsset::class
    ];

    public $js = [
        'js/an602/legacy/jquery.loader.js'
    ];

    public $depends = self::STATIC_DEPENDS;
}
