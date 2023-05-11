<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 *
 */

namespace an602\modules\content\tests\codeception\fixtures;

use an602\modules\content\models\ContentContainerModuleState;
use yii\test\ActiveFixture;

class ContentContainerModuleFixture extends ActiveFixture
{
    public $modelClass = ContentContainerModuleState::class;
    public $dataFile = '@modules/content/tests/codeception/fixtures/data/contentcontainer_module.php';
}
