/*
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 *
 */

/**
 * Module for creating an manipulating modal dialoges.
 * Normal layout of a dialog:
 *
 * <div class="modal">
 *     <div class="modal-dialog">
 *         <div class="modal-content">
 *             <div class="modal-header"></div>
 *             <div class="modal-body"></div>
 *             <div class="modal-footer"></div>
 *         </div>
 *     </div>
 * </div>
 *
 * @param {type} param1
 * @param {type} param2
 */
an602.module('ui.markdown', function (module, require, $) {
    var util = require('util');
    var object = util.object;
    var Widget = require('ui.widget').Widget;
    var client = require('client');
    var modal = require('ui.modal');

    var MarkdownField = function (node, options) {
        Widget.call(this, node, options);
    };

    object.inherits(MarkdownField, Widget);

    MarkdownField.prototype.insert = function(e, chunk) {
        var selected = e.getSelection();
        var content = e.getContent();

        e.replaceSelection(chunk);

        var cursor = selected.start;
        e.setSelection(cursor, cursor + chunk.length);
    };

    MarkdownField.prototype.getUploadButtonWidget = function() {
        var uploadWidget = Widget.instance('#markdown-file-upload');
        uploadWidget.$form = $(this.$.closest('form'));

        if (this.options.filesInputName) {
            uploadWidget.options.uploadSubmitName = this.options.filesInputName;
        } else {
            uploadWidget.options.uploadSubmitName = uploadWidget.data('upload-submit-name');
        }
        return uploadWidget;
    };

    MarkdownField.prototype.init = function () {
        var that = this;
        this.$.markdown({
            iconlibrary: 'fa',
            resize: 'vertical',
            additionalButtons: [
                [{
                    name: "groupCustom",
                    data: [{
                        name: "cmdLinkWiki",
                        title: "URL/Link",
                        icon: {glyph: 'glyphicon glyphicon-link', fa: 'fa fa-link', 'fa-3': 'icon-link'},
                        callback: function (e) {
                            var linkModal = modal.get('#markdown-modal-add-link');
                            $titleInput = linkModal.$.find('.linkTitle');
                            $urlInput = linkModal.$.find('.linkTarget');

                            linkModal.show();

                            $titleInput.val(e.getSelection().text);
                            if ($titleInput.val() == "") {
                                $titleInput.focus();
                            } else {
                                $urlInput.focus();
                            }

                            linkModal.$.find('.addLinkButton').off('click').on('click', function () {
                                that.insert(e, "[" + $titleInput.val() + "](" + $urlInput.val() + ")");
                                linkModal.close();
                            });

                            linkModal.$.on('hide.bs.modal', function (e) {
                                $titleInput.val("");
                                $urlInput.val("");
                            })
                        }
                    },
                    {
                        name: "cmdImgWiki",
                        title: "Image/File",
                        icon: {glyph: 'glyphicon glyphicon-picture', fa: 'fa fa-picture-o', 'fa-3': 'icon-picture'},
                        callback: function (e) {

                            var fileModal = modal.get('#markdown-modal-file-upload');
                            fileModal.show();

                            that.getUploadButtonWidget().off('uploadEnd').on('uploadEnd', function(evt, response) {
                                fileModal.close();
                                $.each(response.result.files, function(i, file) {
                                    var chunk = (file.mimeType.substring(0, 6) == "image/") ? '!' : '';
                                    chunk += "[" + file.name + "](file-guid-" + file.guid + ")";
                                    that.insert(e, chunk);
                                    e.setSelection(e.end, 0);
                                });
                            });
                        }
                    },
                    ]
                }]
            ],
            reorderButtonGroups: ["groupFont", "groupCustom", "groupMisc", "groupUtil"],
            onPreview: function (e) {
                var options = {
                    dataType: 'html',
                    data : {
                        markdown: e.getContent()
                    }
                };

                client.post(that.options.previewUrl, options).then(function(response) {
                    that.$.siblings('.md-preview').html(response.html);
                });

                return "<div><div class='loader'></div></div>";
            }
        });
    };

    module.export({
        MarkdownField: MarkdownField
    });
});
