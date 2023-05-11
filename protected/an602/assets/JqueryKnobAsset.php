<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\assets;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * jquery-knob
 *
 * @author luke
 */
class JqueryKnobAsset extends AssetBundle
{

    public $jsOptions = ['position' => View::POS_BEGIN];

    /**
     * @inheritdoc
     */
    public $sourcePath = '@npm/jquery-knob';

    /**
     * @inheritdoc
     */
    public $js = ['dist/jquery.knob.min.js'];

    public $depends = ['an602\assets\AppAsset'];

}
