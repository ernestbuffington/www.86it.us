<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2018 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\widgets;

use an602\components\Widget;
use an602\libs\Html;
use Yii;

/**
 * PoweredBy widget
 *
 * @since 1.3.7
 * @author Luke
 */
class PoweredBy extends Widget
{

    /**
     * @var bool return text link only
     */
    public $textOnly = false;

    /**
     * @var array link tag HTML options
     */
    public $linkOptions = [];

    /**
     * @inheritdoc
     */
    public function run()
    {

        if (static::isHidden()) {
            return '';
        }

        if ($this->textOnly) {
            return Yii::t('base', 'Powered by {name}', ['name' => 'an602 (https://an602.org)']);
        }

        if (!isset($this->linkOptions['target'])) {
            $this->linkOptions['target'] = '_blank';
        }

        return Yii::t('base', 'Powered by {name}', [
            'name' => Html::a('an602', 'https://an602.org', $this->linkOptions)
        ]);
    }

    public static function isHidden()
    {
        return isset(Yii::$app->params['hidePoweredBy']);
    }

}
