<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2023 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 *
 */

namespace an602\modules\content\events;

use an602\modules\content\models\Content;
use yii\base\ModelEvent;

class ContentEvent extends ModelEvent
{
    public Content $content;
}
