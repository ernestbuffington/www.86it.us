<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2015 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\user\tests\codeception\fixtures;

use yii\test\ActiveFixture;

class ProfileFieldFixture extends ActiveFixture
{
    public $tableName = 'profile_field';
    public $modelClass = 'an602\modules\user\models\ProfileField';
    public $dataFile = '@modules/user/tests/codeception/fixtures/data/profile_field.php';

    public $depends = [
        'an602\modules\user\tests\codeception\fixtures\ProfileFieldCategoryFixture'
    ];
}
