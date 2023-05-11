<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\widgets;

/**
 * DataSavedWidget shows an flash message after saving
 *
 * @deprecated since 1.2 use \an602\modules\ui\view\components\View::saved
 * @package an602.widgets
 * @since 0.5
 * @author Andreas Strobel
 */
class DataSaved extends \yii\base\Widget
{

    /**
     * Displays / Run the Widget
     */
    public function run()
    {
        return $this->render('dataSaved', []);
    }

}
