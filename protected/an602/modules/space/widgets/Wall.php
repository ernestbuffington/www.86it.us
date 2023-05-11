<?php

namespace an602\modules\space\widgets;

use an602\modules\space\models\Space;
use an602\components\Widget;

/**
 * Wall shows a space as wall entry, e.g. in the search
 */

class Wall extends Widget
{
    /*
     * @var Space $space
     */
    public $space;

    public function run()
    {
        return $this->render('spaceWall', ['space' => $this->space]);
    }

}
