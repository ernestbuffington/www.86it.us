<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2015 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\notification\tests\codeception\fixtures;

use yii\test\ActiveFixture;

class NotificationFixture extends ActiveFixture
{

    public $modelClass = 'an602\modules\notification\models\Notification';
    public $dataFile = '@modules/notification/tests/codeception/fixtures/data/notification.php';
    
    public $depends = [
        'an602\modules\user\tests\codeception\fixtures\GroupUserFixture'
    ];

}
