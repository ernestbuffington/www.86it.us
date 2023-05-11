<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2021 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\comment\widgets;

use an602\modules\comment\models\Comment;
use an602\modules\like\widgets\LikeLink;
use an602\widgets\BaseStack;

/**
 * CommentEntryControls
 * @since 1.8
 */
class CommentEntryLinks extends BaseStack
{

    /**
     * @var Comment
     */
    public $object = null;

    /**
     * @inheritdoc
     */
    public $seperator = '&nbsp;&middot;&nbsp;';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->initDefaultWidgets();
        parent::init();
    }

    /**
     * Initialize default widgets for Comment links
     */
    function initDefaultWidgets()
    {
        if (!($this->object instanceof Comment)) {
            return;
        }
        $this->addWidget(CommentLink::class, ['object' => $this->object], ['sortOrder' => 100]);
        $this->addWidget(LikeLink::class, ['object' => $this->object], ['sortOrder' => 200]);
    }

}
