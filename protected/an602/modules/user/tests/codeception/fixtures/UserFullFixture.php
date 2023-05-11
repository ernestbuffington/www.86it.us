<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 *
 */

namespace an602\modules\user\tests\codeception\fixtures;

use an602\modules\content\tests\codeception\fixtures\ContentContainerFixture;
use yii\test\ActiveFixture;

class UserFullFixture extends ActiveFixture
{

    public $tableName = 'user_mentioning';
    public $depends = [
        UserFixture::class,
        UserProfileFixture::class,
        ContentContainerFixture::class,
        UserPasswordFixture::class,
        UserFollowFixture::class,
        InviteFixture::class,
        GroupSpaceFixture::class,
        GroupFixture::class,
    ];

}
