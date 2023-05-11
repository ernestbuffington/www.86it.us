<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\space\components;

use an602\components\ContentContainerUrlRule;
use an602\modules\content\components\ContentContainerActiveRecord;
use an602\modules\space\models\Space;

/**
 * Space URL Rule
 *
 * @author luke
 */
class UrlRule extends ContentContainerUrlRule
{

    /**
     * @inheritdoc
     */
    protected $defaultRoute = 'space/space';

    /**
     * @inheritdoc
     */
    protected $urlPrefix = 's';

    /**
     * @inheritdoc
     */
    protected $routePrefixes = ['<contentContainer>', '<spaceContainer>'];

    /**
     * @inheritdoc
     */
    public static $containerUrlMap = [];

    /**
     * @inheritdoc
     */
    protected static function getContentContainerByUrl(string $url): ?ContentContainerActiveRecord
    {
        return Space::find()->where(['guid' => $url])->orWhere(['url' => $url])->one();
    }

    /**
     * @inheritdoc
     */
    protected static function getContentContainerByGuid(string $guid): ?ContentContainerActiveRecord
    {
        return Space::findOne(['guid' => $guid]);
    }

    /**
     * @inheritdoc
     */
    protected static function getUrlMapFromContentContainer(ContentContainerActiveRecord $contentContainer): ?string
    {
        return $contentContainer->url ?? $contentContainer->guid ?? null;
    }

    /**
     * @inheritdoc
     */
    protected static function isContentContainerInstance(ContentContainerActiveRecord $contentContainer): bool
    {
        return ($contentContainer instanceof Space);
    }

}
