<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2020 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\assets;

use an602\components\assets\AssetBundle;

/**
 * Fixes https://github.com/an602/an602/issues/4638 by aligning jui and icu month short names
 *
 * @author buddha
 * @since 1.7.1
 */
class DatePickerRussianLanguageAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $basePath = '@webroot-static';

    /**
     * @inheritdoc
     */
    public $baseUrl = '@web-static';

    /**
     * @inheritdoc
     */
    public $js = [
        'js/compat/date/i18n/datepicker-ru.js',
    ];

    public $depends = [
        'yii\jui\JuiAsset',
    ];

}
