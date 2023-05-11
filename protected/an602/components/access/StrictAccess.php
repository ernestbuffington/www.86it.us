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
 * Time: 23:25
 */

namespace an602\components\access;

/**
 * StrictAccess should be used by all controllers which don't allow guest access if guest mode is inactive.
 * There are only some controllers which require guest access even if guest mode is not active as Login, Registration etc.
 *
 * @package an602\components\access
 */
class StrictAccess extends ControllerAccess
{
    public function getFixedRules()
    {
        $fixed = parent::getFixedRules();
        $fixed[] = [self::RULE_STRICT];
        return $fixed;
    }
}
