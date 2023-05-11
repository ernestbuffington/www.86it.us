<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2015 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\user\tests\codeception\fixtures;

use yii\test\ActiveFixture;

class GroupUserFixture extends ActiveFixture
{

    public $modelClass = 'an602\modules\user\models\GroupUser';
    public $dataFile = '@modules/user/tests/codeception/fixtures/data/group_user.php';

    public $depends = [
        UserFixture::class,
        GroupFixture::class
    ];

}
