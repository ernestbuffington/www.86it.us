<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2016 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\space\widgets;

use Yii;
use yii\base\Widget;

/**
 * This widget will added to the sidebar and show infos about the current selected space
 *
 * @author Andreas Strobel
 * @since 0.5
 */
class Header extends Widget
{

    /**
     * @var \an602\modules\space\models\Space the Space which this header belongs to
     */
    public $space;

    /**
     * @inheritdoc
     */
    public function run()
    {
        return $this->render('header', [
            'space' => $this->space,
            // Deprecated variables below (will removed in future versions)
            'followingEnabled' => !Yii::$app->getModule('space')->disableFollow,
            'postCount' => -1
        ]);
    }

}
