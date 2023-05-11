<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2016 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\widgets\mails;

use Yii;

/**
 * MailButton renders a button for email layouts/views.
 *
 * @author buddha
 * @since 1.2
 */
class MailButton extends \yii\base\Widget
{

    /**
     * @var string hex color, default is primary theme color
     */
    public $color;

    /**
     * @var string can be used instead of $color and accepts values as primary|info|success or any other theme variable etc. 
     */
    public $type;

    /**
     * @var string target url 
     */
    public $url;

    /**
     * @var string button text
     */
    public $text;

    /**
     * @inheritdoc
     */
    public function run()
    {
        if ($this->type) {
            $this->color = Yii::$app->view->theme->variable($this->type);
        }

        if (!$this->color) {
            $this->color = Yii::$app->view->theme->variable('primary');
        }

        return $this->render('mailButton', [
                    'color' => $this->color,
                    'url' => $this->url,
                    'text' => $this->text
        ]);
    }

}
