<?php

namespace an602\modules\content\widgets;

use an602\modules\content\components\ContentActiveRecord;

/**
 * WallEntryLinksWidget is an instance of StackWidget.
 *
 * Display some links below a wall entry. Allows modules to add own links to
 * the wall entry.
 *
 * @package an602.modules_core.wall.widgets
 * @since 0.5
 */
class WallEntryLinks extends \an602\widgets\BaseStack
{

    /**
     * @var ContentActiveRecord
     */
    public $object = null;

    /**
     * @inheritdoc
     */
    public $seperator = '&nbsp;&middot;&nbsp;';

    /**
     * @inheritdoc
     */
    public $template = '<div class="wall-entry-controls wall-entry-links">{content}</div>';

}
