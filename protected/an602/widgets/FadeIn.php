<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 *
 */

/**
 * Created by PhpStorm.
 * User: buddha
 * Date: 25.07.2017
 * Time: 14:31
 */

namespace an602\widgets;


/**
 * Simple FadeIn JsWidget
 * @since 1.2.2
 */
class FadeIn extends JsWidget
{

    /**
     * @inheritdoc
     */
    public $fadeIn = true;

    /**
     * @inheritdoc
     */
    public $jsWidget = 'ui.widget.Widget';

    /**
     * @inheritdoc
     */
    public $init = true;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        ob_start();
        ob_implicit_flush(false);
    }

    public function run()
    {
        $this->content = ob_get_clean();
        return parent::run();
    }

}
