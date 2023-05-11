<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 *
 */

namespace an602\modules\content\tests\codeception\fixtures;

use an602\modules\content\models\ContentTag;
use yii\test\ActiveFixture;

class ContentTagFixture extends ActiveFixture
{
    public $modelClass = ContentTag::class;
    public $dataFile = '@modules/content/tests/codeception/fixtures/data/content_tag.php';
}
