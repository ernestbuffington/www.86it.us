/**
 * This module is used to initialize CodeMirror
 *
 * @namespace an602.modules.ui.codemirror
 */
an602.module('ui.codemirror', function(module, require, $) {
    var event = require('event');

    var init = function () {
        event.on('an602:ready', function (evt) {
            var initCodeMirrorInterval = setInterval(function () {

                if(!$('textarea[data-codemirror]').length) {
                    clearInterval(initCodeMirrorInterval);
                }

                if (typeof CodeMirror !== 'undefined') {
                    $('textarea[data-codemirror]').each(function() {
                        if(typeof $(this).data('codemirror-instance') === 'object') {
                            $(this).data('codemirror-instance').toTextArea();
                        }

                        var codeMirrorInstance = CodeMirror.fromTextArea(this, {
                            mode: $(this).data('codemirror'),
                            lineNumbers: true,
                            extraKeys: {'Ctrl-Space': 'autocomplete'}
                        });
                        $(this).data('codemirror-instance', codeMirrorInstance);
                    });

                    clearInterval(initCodeMirrorInterval);
                }

            }, 200);
        });
    }

    module.export({
        init
    });
});
