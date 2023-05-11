<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2015 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\search\widgets;

use yii\base\Widget;

/**
 * SearchMenu Widget for TopMenu
 */
class SearchMenu extends Widget
{

    /**
     * @inheritdoc
     */
    public function run()
    {
        return $this->render('searchMenu', []);
    }

}
