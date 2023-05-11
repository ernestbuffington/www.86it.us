<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2021 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 *
 */

namespace an602\modules\content\tests\codeception\fixtures;

use an602\modules\content\models\ContentContainerTag;
use yii\test\ActiveFixture;

class ContentContainerTagFixture extends ActiveFixture
{
    public $modelClass = ContentContainerTag::class;
    public $dataFile = '@modules/content/tests/codeception/fixtures/data/contentcontainer_tag.php';
}
