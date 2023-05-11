<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\admin\widgets;

use an602\libs\SelfTest;

/**
 * PrerequisitesList widget shows all current prerequisites
 *
 * @since 1.1
 * @author Luke
 */
class PrerequisitesList extends \yii\base\Widget
{

    /**
     * @inheritdoc
     */
    public function run()
    {
        return $this->render('prerequisitesList', ['checks' => SelfTest::getResults()]);
    }

    /**
     * Check there is an error
     *
     * @return boolean
     */
    public static function hasError()
    {
        foreach (SelfTest::getResults() as $check) {
            if ($check['state'] == 'ERROR') {
                return true;
            }
        }

        return false;
    }

}
