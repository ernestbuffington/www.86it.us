<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 *
 */

/**
 * Created by PhpStorm.
 * User: buddha
 * Date: 24.07.2017
 * Time: 15:56
 */

namespace an602\modules\content\tests\codeception\unit;


use an602\modules\content\models\ContentTag;

class TestTagSameModule extends ContentTag
{
    public $moduleId = 'test';

    public $includeTypeQuery = true;

    public static function getLabel()
    {
        return 'testCategory';
    }

}
