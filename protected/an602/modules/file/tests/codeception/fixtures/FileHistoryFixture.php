<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 *
 */

namespace an602\modules\file\tests\codeception\fixtures;

use an602\modules\file\models\FileHistory;
use yii\test\ActiveFixture;

class FileHistoryFixture extends ActiveFixture
{

    public $modelClass = FileHistory::class;
    public $dataFile = '@file/tests/codeception/fixtures/data/file-history.php';

}
