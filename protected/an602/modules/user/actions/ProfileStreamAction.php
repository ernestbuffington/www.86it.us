<?php


namespace an602\modules\user\actions;

use an602\modules\stream\actions\ContentContainerStream;
use an602\modules\user\models\User;
use an602\modules\user\stream\ProfileStreamQuery;

/**
 * ProfileStream
 *
 * @package an602\modules\user\components
 */
class ProfileStreamAction extends ContentContainerStream
{
    /**
     * @inheritdoc
     */
    public $streamQueryClass = ProfileStreamQuery::class;

    /**
     * @inheritdoc
     */
    protected function beforeRun()
    {
        if(!$this->contentContainer instanceof User) {
            return false;
        }

        return parent::beforeRun();
    }
}
