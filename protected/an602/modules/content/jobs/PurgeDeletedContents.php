<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2023 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\content\jobs;

use an602\modules\content\models\Content;
use an602\modules\queue\ActiveJob;

class PurgeDeletedContents extends ActiveJob
{

    /**
     * @inheritdoc
     */
    public function run()
    {
        foreach (Content::findAll(['content.state' => Content::STATE_DELETED]) as $content) {
            $content->delete();
        }
    }

}
