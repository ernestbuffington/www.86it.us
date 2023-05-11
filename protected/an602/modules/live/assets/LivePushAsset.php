<?php


namespace an602\modules\live\assets;


use an602\assets\SocketIoAsset;
use an602\components\assets\AssetBundle;

class LivePushAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@live/resources';

    /**
     * @inheritdoc
     */
    public $js = [
        'js/an602.live.push.js',
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        LiveAsset::class,
        SocketIoAsset::class
    ];

}
