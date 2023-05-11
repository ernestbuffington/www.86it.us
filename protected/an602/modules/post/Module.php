<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\post;

use an602\modules\content\components\ContentContainerActiveRecord;
use an602\modules\content\components\ContentContainerModule;
use an602\modules\post\models\Post;

/**
 * Post Submodule
 *
 * @author Luke
 * @since 0.5
 */
class Module extends ContentContainerModule
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'an602\modules\post\controllers';

    /**
     * @since 1.14
     * @var bool Automatically increase font size for short posts.
     */
    public bool $enableDynamicFontSize = false;

    /**
     * @since 1.15
     * @var int collapsed post block height
     */
    public int $collapsedPostHeight = 300;

    /**
     * @inheritdoc
     */
    public function getPermissions($contentContainer = null)
    {
        if ($contentContainer !== null) {
            return [
                new permissions\CreatePost()
            ];
        }

        return [];
    }

    /**
     * @inheritdoc
     */
    public function getContentClasses(?ContentContainerActiveRecord $contentContainer = null): array
    {
        return [Post::class];
    }
}
