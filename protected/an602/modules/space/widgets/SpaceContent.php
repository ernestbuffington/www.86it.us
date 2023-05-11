<?php

namespace an602\modules\space\widgets;

use an602\components\Widget;
use an602\modules\content\components\ContentContainerActiveRecord;

class SpaceContent extends Widget
{
    /**
     * @var string
     */
    public $content = '';

    /**
     * @var ContentContainerActiveRecord
     */
    public $contentContainer;

    public function run()
    {
        return $this->content;
    }
}
