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
 * Date: 27.07.2017
 * Time: 00:06
 */

namespace an602\tests\codeception\unit\components\access;


use an602\libs\BasePermission;

class AccessTestPermission2 extends BasePermission
{
    public $moduleId = 'test';

    public $id = 'content-test-permission';

}
