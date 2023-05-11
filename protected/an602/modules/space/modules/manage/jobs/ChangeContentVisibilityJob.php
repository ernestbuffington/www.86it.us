<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2023 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\space\modules\manage\jobs;

use an602\modules\content\models\Content;
use an602\modules\queue\ActiveJob;

class ChangeContentVisibilityJob extends ActiveJob
{
    public int $contentContainerId;

    public int $visibility;

    public function run()
    {
        /** @var Content[] $contents */
        $contents = Content::find()
            ->where(['contentcontainer_id' => $this->contentContainerId])
            ->each();

        foreach ($contents as $content) {
            $content->visibility = $this->visibility;
            $content->save(false);
        }
    }
}
