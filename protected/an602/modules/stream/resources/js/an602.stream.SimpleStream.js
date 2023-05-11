/*
 * @link https://metamz.network/
 * @copyright Copyright (c) 2018 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 *
 */

/**
 * Simple stream is used for
 * @type Function
 */
an602.module('stream.SimpleStream', function (module, require, $) {


    var Stream = require('stream').Stream;
    var Component = require('action').Component;
    var client = require('client');
    var content = require('content');

    /**
     * Simple stream component can be used for static streams without load logic (only reload single content).
     *
     * @param {type} container
     * @param {type} cfg
     */
    var SimpleStream = Stream.extend(function (container, cfg) {
        Stream.call(this, container, cfg);
        this.$content = this.$;
        this.setFilter('entry_archived');
    });

    SimpleStream.prototype.onEmptyStream = function () {
        var modal = Component.instance(this.$.closest('.modal'));;
        if(modal) {
            modal.close();
        }
    };

    SimpleStream.prototype.reloadEntry = function (entry) {
        if(!entry) {
            entry = Component.instance(this.$.find('[data-stream-entry]:first'));
        }

        entry.loader();
        var contentId = entry.getKey();
        return client.get(content.config.reloadUrl, {data: {id: contentId}}).then(function (response) {
            if (response.output) {
                entry.replace(response.output);
            }
            return response;
        }).catch(function (err) {
            module.log.error(err, true);
        });
    };

    SimpleStream.prototype.loadEntry = function (contentId) {
        var that = this;

        return client.get(content.config.reloadUrl, {data: {id: contentId}}).then(function (response) {
            that.appendEntry(response.output);
            return response;
        });
    };

    module.export = SimpleStream;
});
