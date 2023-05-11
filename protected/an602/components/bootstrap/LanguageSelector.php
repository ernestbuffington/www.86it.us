<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\components\bootstrap;

use yii\base\BootstrapInterface;

/**
 * LanguageSelector automatically sets the language of the i18n component
 *
 * @see \an602\components\i18n\I18N
 * @author luke
 */
class LanguageSelector implements BootstrapInterface
{

    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        mb_internal_encoding('UTF-8');

        $app->i18n->autosetLocale();
    }
}
