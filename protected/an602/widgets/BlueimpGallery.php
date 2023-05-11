<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2016 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\widgets;

/**
 * BlueimpGallery gallery layout
 *
 * @see LayoutAddons
 * @author buddha
 * @since 1.2
 */
class BlueimpGallery extends \yii\base\Widget
{

    /**
     * @inheritdoc
     */
    public function run()
    {
        return $this->render('blueimpGallery');
    }

}
