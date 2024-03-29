<?php

use an602\modules\ui\form\assets\MarkdownFieldAsset;
use yii\helpers\Url;
use yii\helpers\Html;

/**
 * Register BootstrapMarkdown & changes
 */
MarkdownFieldAsset::register($this);

/**
 * Create a hidden field to store uploaded files guids
 */
echo Html::hiddenInput('fileUploaderHiddenGuidField', "", ['id' => 'fileUploaderHiddenGuidField_' . $fieldId]);

$this->registerJsVar('markdownPreviewUrl', $previewUrl);

$translations = [
    'Bold' => Yii::t('UiModule.markdownEditor', 'Bold'),
    'Italic' => Yii::t('UiModule.markdownEditor', 'Italic'),
    'Heading' => Yii::t('UiModule.markdownEditor', 'Heading'),
    'URL/Link' => Yii::t('UiModule.markdownEditor', 'URL/Link'),
    'Image/File' => Yii::t('UiModule.markdownEditor', 'Image/File'),
    'Image' => Yii::t('UiModule.markdownEditor', 'Image'),
    'List' => Yii::t('UiModule.markdownEditor', 'List'),
    'Preview' => Yii::t('UiModule.markdownEditor', 'Preview'),
    'strong text' => Yii::t('UiModule.markdownEditor', 'strong text'),
    'emphasized text' => Yii::t('UiModule.markdownEditor', 'emphasized text'),
    'heading text' => Yii::t('UiModule.markdownEditor', 'heading text'),
    'enter link description here' => Yii::t('UiModule.markdownEditor', 'enter link description here'),
    'Insert Hyperlink' => Yii::t('UiModule.markdownEditor', 'Insert Hyperlink'),
    'enter image description here' => Yii::t('UiModule.markdownEditor', 'enter image description here'),
    'Insert Image Hyperlink' => Yii::t('UiModule.markdownEditor', 'Insert Image Hyperlink'),
    'enter image title here' => Yii::t('UiModule.markdownEditor', 'enter image title here'),
    'list text here' => Yii::t('UiModule.markdownEditor', 'list text here'),
    'Quote' => Yii::t('UiModule.markdownEditor', 'Quote'),
    'quote here' => Yii::t('UiModule.markdownEditor', 'quote here'),
    'Code' => Yii::t('UiModule.markdownEditor', 'Code'),
    'code text here' => Yii::t('UiModule.markdownEditor', 'code text here'),
    'Unordered List' => Yii::t('UiModule.markdownEditor', 'Unordered List'),
    'Ordered List' => Yii::t('UiModule.markdownEditor', 'Ordered List'),
];

$translationsJS = "$.fn.markdown.messages['en'] = {\n";
foreach ($translations as $key => $value) {
    $translationsJS .= "\t'" . $key . "': '" . Html::encode($value) . "',\n";
}
$translationsJS .= "};\n";
$this->registerJs($translationsJS);
$this->registerJs("initMarkdownEditor('" . $fieldId . "')");

?>

<?php
/**
 * We need to use this script part since a markdown editor can also included
 * into a modal. So we need to append MarkdownEditors modals later to body.
 */
?>
<script <?= \an602\libs\Html::nonce() ?> id="markdownEditor_dialogs_<?php echo $fieldId; ?>" type="text/placeholder">
    <div class="modal modal-top" id="addFileModal_<?php echo $fieldId; ?>" tabindex="-1" role="dialog" aria-labelledby="addImageModalLabel" style="z-index:99999" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="addImageModalLabel"><?php echo Yii::t('UiModule.markdownEditor', 'Add image/file'); ?></h4>
    </div>
    <div class="modal-body">

    <div class="uploadForm">
    <?php echo Html::beginForm('', 'post'); ?>
    <input class="fileUploadButton" type="file"
    name="files[]"
    data-url="<?php echo Url::to(['/file/file/upload']); ?>"
    multiple>
    <?php echo Html::endForm(); ?>
    </div>

    <div class="uploadProgress">
    <strong><?php echo Yii::t('UiModule.markdownEditor', 'Please wait while uploading...'); ?></strong>
    </div>


    </div>
    <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo Yii::t('UiModule.markdownEditor', 'Close'); ?></button>
    </div>
    </div>
    </div>
    </div>

    <div class="modal modal-top" id="addLinkModal_<?php echo $fieldId; ?>" tabindex="-1" role="dialog" style="z-index:99999" aria-labelledby="addLinkModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
    aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="addLinkModalLabel"><?php echo Yii::t('UiModule.markdownEditor', 'Add link'); ?></h4>
    </div>
    <div class="modal-body">
    <div class="form-group">
    <label for="addLinkTitle"><?php echo Yii::t('UiModule.markdownEditor', 'Title'); ?></label>
    <input type="text" class="form-control linkTitle"
    placeholder="<?php echo Yii::t('UiModule.markdownEditor', 'Title of your link'); ?>">
    </div>
    <div class="form-group">
    <label for="addLinkTarget"><?php echo Yii::t('UiModule.markdownEditor', 'Target'); ?></label>
    <input type="text" class="form-control linkTarget"
    placeholder="<?php echo Yii::t('UiModule.markdownEditor', 'Enter a url (e.g. http://example.com)'); ?>">
    </div>
    </div>
    <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo Yii::t('UiModule.markdownEditor', 'Close'); ?></button>
    <button type="button" class="btn btn-primary addLinkButton"><?php echo Yii::t('UiModule.markdownEditor', 'Add link'); ?></button>
    </div>
    </div>
    </div>
    </div>
</script>
