<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2016 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\file\widgets;

use an602\components\ActiveRecord;
use an602\modules\content\widgets\WallEntry;
use an602\modules\file\converter\PreviewImage;
use Yii;
use an602\modules\content\components\ContentActiveRecord;

/**
 * This widget is used include the files functionality to a wall entry.
 *
 * @since 0.5
 */
class ShowFiles extends \yii\base\Widget
{

    /**
     * @var ActiveRecord Object to show files from
     */
    public $object = null;

    /**
     * @var bool if set to false this widget won't be rendered
     */
    public $active = true;

    /**
     * @var bool if set to false this widget won't render file previews as images/videos/audio
     */
    public $preview = true;

    /**
     * Executes the widget.
     */
    public function run()
    {
        if(!$this->active) {
            return;
        }

        $excludeMediaFilesPreview = ($this->preview) ? Yii::$app->getModule('file')->settings->get('excludeMediaFilesPreview') : false;

        return $this->render('showFiles', [
                    'files' => $this->object->fileManager->findStreamFiles(),
                    'object' => $this->object,
                    'previewImage' => new PreviewImage(),
                    'showPreview' => $this->preview,
                    'excludeMediaFilesPreview' => $excludeMediaFilesPreview
        ]);
    }

}

?>
