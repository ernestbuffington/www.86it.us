<?php


namespace an602\assets;


use yii\web\AssetBundle;

class TopNavigationAsset extends AssetBundle
{
    public $jsOptions = ['position' => \yii\web\View::POS_END];

    public $basePath = '@webroot-static';
    public $baseUrl = '@web-static';

    /**
     * @inheritdoc
     */
    public $js = ['js/an602/an602.ui.topNavigation.js'];

}
