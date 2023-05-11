<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2015 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\content\tests\codeception\fixtures;

use yii\test\ActiveFixture;

class ContentContainerSettingFixture extends ActiveFixture
{

    public $modelClass = 'an602\modules\content\models\ContentContainerSetting';
    public $dataFile = '@modules/content/tests/codeception/fixtures/data/contentcontainer_setting.php';

}
