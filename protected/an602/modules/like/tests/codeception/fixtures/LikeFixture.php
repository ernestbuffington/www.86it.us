<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2015 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\like\tests\codeception\fixtures;

use yii\test\ActiveFixture;

class LikeFixture extends ActiveFixture
{

    public $modelClass = 'an602\modules\like\models\Like';
    public $dataFile = '@modules/like/tests/codeception/fixtures/data/like.php';

}
