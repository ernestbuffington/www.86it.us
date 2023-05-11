<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2018 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\like;

use Yii;
use an602\modules\like\models\Like;
use an602\modules\space\models\Space;
use an602\modules\content\components\ContentActiveRecord;

/**
 * This module provides like support for Content and Content Addons
 * Each wall entry will get a Like Button and a overview of likes.
 *
 * @since 0.5
 */
class Module extends \an602\components\Module
{

    /**
     * @inheritdoc
     */
    public $isCoreModule = true;

    /**
     * @var boolean automatic follow liked content
     * @since 1.2.5
     */
    public $autoFollowLikedContent = false;

    /**
     * @var bool mark this core module as enabled
     * @since 1.4
     */
    public $isEnabled = true;

    /**
     * @inheritdoc
     */
    public function getPermissions($contentContainer = null)
    {
        if(isset($contentContainer)) {
            return [
                new permissions\CanLike()
            ];
        }

        return [];
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return Yii::t('LikeModule.base', 'Like');
    }

    /**
     * @inheritdoc
     */
    public function getNotifications()
    {
        if (!$this->isEnabled) {
            return [];
        }

        return [
            'an602\modules\like\notifications\NewLike'
        ];
    }

    /**
     * Checks if given content object can be liked
     *
     * @param Like|ContentActiveRecord $object
     * @return boolean can like
     */
    public function canLike($object)
    {
        $content = $object->content;

        if (isset($content->container) && !$content->container->can(new permissions\CanLike())) {
            return false;
        }

        return true;
    }

}
