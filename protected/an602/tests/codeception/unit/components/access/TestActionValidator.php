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
 * Date: 28.07.2017
 * Time: 17:47
 */

namespace an602\tests\codeception\unit\components\access;


use an602\components\access\ActionAccessValidator;

class TestActionValidator extends ActionAccessValidator
{
    protected function validate($rule)
    {
        if(!$rule['return']) {
            $this->access->code = 404;
            $this->access->reason = 'Not you again!';
            return false;
        }

        return true;
    }
}
