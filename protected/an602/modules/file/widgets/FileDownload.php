<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 *
 */

namespace an602\modules\file\widgets;

use an602\libs\MimeHelper;
use an602\modules\file\models\File;
use an602\widgets\Button;
use Yii;
use yii\helpers\Html;
use yii\helpers\Url;

class FileDownload extends Button
{
    public function file(File $file, $withIcon = true, $showSize = true, $download = false, $scheme = false)
    {
        if($withIcon) {
            $mimeIconClass = MimeHelper::getMimeIconClassByExtension($file);
            $this->icon(Html::tag('i', '', ['class' => 'mime '.$mimeIconClass, 'style' => 'width:10px;height:10px;']), false, true);
        }

        if($showSize) {
            $this->text .= static::getFileSizeString($file);
        }

        $this->link(static::getUrl($file, $download, $scheme));
        $this->options(static::getFileDataAttributes($file));

        return $this;
    }

    public static function getFileSizeString(File $file)
    {
        return ' <small>('.Yii::$app->formatter->asShortSize($file->size, 1).')</small>';
    }

    public static function getFileDataAttributes(File $file)
    {
        return [
            'data-pjax-prevent' => true,
            'data-file-download' => true,
            'data-file-url' => $file->getUrl(['download' => true], true),
            'data-file-name' => $file->file_name,
            'data-file-mime' => $file->mime_type,
        ];
    }

    public static function getUrl(File $file, $download, $scheme)
    {
        return $file->getUrl(['download' => $download], $scheme);
    }

}
