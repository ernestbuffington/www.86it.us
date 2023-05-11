<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2016 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\widgets\mails;

/**
 * MailButtonList renders multiple buttons for email layouts/views.
 *
 * @author buddha
 * @since 1.2
 */
class MailButtonList extends \yii\base\Widget
{

    /**
     * @var string hex color
     */
    public $buttons = [];


    /**
     * @inheritdoc
     */
    public function run()
    {
        return $this->render('mailButtonList', [
                    'buttons' => $this->buttons
        ]);
    }
}
