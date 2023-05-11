<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2015 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\friendship\tests\codeception\fixtures;

use yii\test\ActiveFixture;

class FriendshipFixture extends ActiveFixture
{
    public $modelClass = 'an602\modules\friendship\models\FriendShip';
    public $dataFile = '@modules/friendship/tests/codeception/fixtures/data/friendship.php';
}
