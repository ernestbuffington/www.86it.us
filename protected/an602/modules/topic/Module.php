<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 *
 */

namespace an602\modules\topic;

use an602\modules\topic\permissions\ManageTopics;
use Yii;
use an602\modules\topic\permissions\AddTopic;
use an602\modules\space\models\Space;

/**
 * Admin Module
 */
class Module extends \an602\components\Module
{

    /**
     * @var string defines the icon for topics used in badges etc.
     */
    public $icon = 'fa-star';

    /**
     * @inheritdoc
     */
    public function getPermissions($contentContainer = null)
    {
        if ($contentContainer instanceof Space) {
            return [
                new AddTopic(),
                new ManageTopics(),
            ];
        }

        return [];
    }
}
