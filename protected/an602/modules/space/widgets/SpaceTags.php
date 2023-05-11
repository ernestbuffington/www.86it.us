<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2021 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\space\widgets;

use an602\modules\space\models\Space;
use an602\components\Widget;

/**
 * SpaceTags lists all tags of the Space
 */
class SpaceTags extends Widget
{

    /**
     * @var Space
     */
    public $space;

    /**
     * @inheritDoc
     */
    public function run()
    {
        return $this->render('spaceTags', ['space' => $this->space]);
    }

}

?>
