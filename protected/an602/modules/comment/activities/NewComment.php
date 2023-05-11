<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\comment\activities;

use an602\modules\comment\models\Comment;
use Yii;
use an602\modules\activity\components\BaseActivity;
use an602\modules\activity\interfaces\ConfigurableActivityInterface;

/**
 * NewComment activity
 *
 * @author luke
 */
class NewComment extends BaseActivity implements ConfigurableActivityInterface
{

    /**
     * @inheritdoc
     */
    public $moduleId = 'comment';

    /**
     * @inheritdoc
     */
    public $viewName = "newComment";

    /**
     * @var Comment
     */
    public $source;

    /**
     * @inheritdoc
     */
    public function getTitle()
    {
        return Yii::t('CommentModule.base', 'Comments');
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return Yii::t('CommentModule.base', 'Whenever a new comment was written.');
    }

    /**
     * @inheritdoc
     */
    public function getUrl()
    {
        return $this->source->url;
    }

}
