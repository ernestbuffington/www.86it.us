<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2021 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\installer;

use yii\db\Connection;

/**
 * Events provides callbacks to handle events.
 */
class Events extends \yii\base\BaseObject
{

    public static function onConnectionAfterOpen($event)
    {
        /* @var $connection Connection */
        $connection = $event->sender;

        if (in_array($connection->getDriverName(), ['mysql', 'mysqli'], true)) {
            $connection->pdo->exec('SET default_storage_engine = InnoDB');
        }
    }

}
