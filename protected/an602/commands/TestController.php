<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\commands;

use Yii;
use yii\helpers\Console;

/**
 * TestController provides some console tests
 *
 * @inheritdoc
 */
class TestController extends \yii\console\Controller
{

    /**
     * Sends a test e-mail to the given e-mail address
     *
     * @param string $address the e-mail address
     */
    public function actionEmail($address)
    {
        $message = "Console test message<br /><br />";

        $mail = Yii::$app->mailer->compose(['html' => '@an602/views/mail/TextOnly'], ['message' => $message]);
        $mail->setTo($address);
        $mail->setSubject('Test message');
        $mail->send();

        Console::output("Message successfully sent!");
    }
}
