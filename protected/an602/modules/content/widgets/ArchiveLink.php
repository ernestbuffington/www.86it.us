<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2015 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\content\widgets;

use Yii;
use an602\modules\content\components\ContentContainerController;

/**
 * PinLink for Wall Entries
 *
 * This widget will attached to the WallEntryControlsWidget and displays
 * the "Pin or Unpin" Link to the Content Objects.
 *
 * @since 0.5
 */
class ArchiveLink extends \yii\base\Widget
{

    /**
     * @var \an602\modules\content\components\ContentActiveRecord
     */
    public $content;

    /**
     * Executes the widget.
     */
    public function run()
    {
        if (!$this->content->content->canArchive()) {
            return '';
        }

        return $this->render('archiveLink', [
                    'object' => $this->content,
                    'id' => $this->content->content->id,
        ]);
    }

}

?>
