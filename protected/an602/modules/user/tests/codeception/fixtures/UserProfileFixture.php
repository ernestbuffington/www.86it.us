<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2015 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\user\tests\codeception\fixtures;

use yii\test\ActiveFixture;

class UserProfileFixture extends ActiveFixture
{

    public $modelClass = 'an602\modules\user\models\Profile';
    public $dataFile = '@modules/user/tests/codeception/fixtures/data/profile.php';

    public $depends = [
        'an602\modules\user\tests\codeception\fixtures\ProfileFieldFixture'
    ];

}
