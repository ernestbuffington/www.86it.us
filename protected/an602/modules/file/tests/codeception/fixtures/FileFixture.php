<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 *
 */

namespace an602\modules\file\tests\codeception\fixtures;

use an602\modules\file\models\File;
use yii\test\ActiveFixture;

class FileFixture extends ActiveFixture
{

    public $modelClass = File::class;
    public $dataFile = '@file/tests/codeception/fixtures/data/file.php';

}
