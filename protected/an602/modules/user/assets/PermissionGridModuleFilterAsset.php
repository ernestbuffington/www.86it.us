<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2019 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\user\assets;


use an602\components\assets\AssetBundle;

class PermissionGridModuleFilterAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@user/resources';

    /**
     * @inheritdoc
     */
    public $js = [
        'js/an602.user.PermissionGridModuleFilter.js',
    ];
}
