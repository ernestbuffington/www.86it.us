<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2021 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\content\widgets;

use an602\modules\content\components\ContentActiveRecord;
use yii\base\Widget;
use yii\helpers\Url;

/**
 * Lock/Unlock comments link for Wall Entries.
 *
 * @package an602.modules_core.wall.widgets
 * @since 1.10
 */
class LockCommentsLink extends Widget
{

    /**
     * @var ContentActiveRecord
     */
    public $contentRecord;

    /**
     * @inheritdoc
     */
    public function run()
    {
        $content = $this->contentRecord->content;

        if (!$content->canLockComments()) {
            return '';
        }

        return $this->render('lockCommentsLink', [
            'content' => $content,
            'lockCommentsLink' => Url::to(['/content/content/lock-comments', 'id' => $content->id]),
            'unlockCommentsLink' => Url::to(['/content/content/unlock-comments', 'id' => $content->id]),
        ]);
    }
}
