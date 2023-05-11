<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\file\libs;

use an602\modules\file\Module;
use an602\modules\file\widgets\FileDownload;
use an602\libs\Html;
use an602\libs\MimeHelper;
use an602\modules\file\models\File;
use an602\modules\file\handler\FileHandlerCollection;
use an602\modules\file\handler\DownloadFileHandler;
use an602\modules\file\converter\PreviewImage;
use an602\modules\content\components\ContentActiveRecord;
use Yii;
use yii\helpers\Url;

/**
 * FileHelper
 *
 * @since 1.2
 * @author Luke
 */
class FileHelper extends \yii\helpers\FileHelper
{

    /**
     * Checks if given fileName has a extension
     *
     * @param string $fileName the filename
     * @return boolean has extension
     */
    public static function hasExtension($fileName)
    {
        return (strpos($fileName, '.') !== false);
    }

    /**
     * Returns the extension of a file
     *
     * @param string|File $fileName the filename or File model
     * @return string the extension
     */
    public static function getExtension($fileName)
    {
        if ($fileName instanceof File) {
            $fileName = $fileName->file_name;
        }

        if (!is_string($fileName)) {
            return '';
        }

        $fileParts = pathinfo($fileName);
        if (isset($fileParts['extension'])) {
            return $fileParts['extension'];
        }

        return '';
    }

    /**
     * Creates a file with options
     *
     * @since 1.2
     * @param \an602\modules\file\models\File $file
     * @return string the rendered HTML link
     */
    public static function createLink(File $file, $options = [], $htmlOptions = [])
    {
        $label = (isset($htmlOptions['label'])) ? $htmlOptions['label'] : Html::encode($file->fileName);

        $fileHandlers = FileHandlerCollection::getByType([FileHandlerCollection::TYPE_VIEW, FileHandlerCollection::TYPE_EXPORT, FileHandlerCollection::TYPE_EDIT, FileHandlerCollection::TYPE_IMPORT], $file);
        if (count($fileHandlers) === 1 && $fileHandlers[0] instanceof DownloadFileHandler) {
            $htmlOptions['target'] = '_blank';
            $htmlOptions = array_merge($htmlOptions,  FileDownload::getFileDataAttributes($file));
            return Html::a($label, $file->getUrl(), $htmlOptions);
        }

        $htmlOptions = array_merge($htmlOptions, ['data-target' => '#globalModal']);

        $urlOptions = ['/file/view', 'guid' => $file->guid];

        return Html::a($label, Url::to($urlOptions), $htmlOptions);
    }

    /**
     * Determines the content container of a File record
     *
     * @since 1.2
     * @param File $file
     * @return \an602\modules\content\components\ContentContainerActiveRecord the content container or null
     */
    public static function getContentContainer(File $file)
    {
        $relation = $file->getPolymorphicRelation();

        if ($relation !== null && $relation instanceof ContentActiveRecord) {
            if ($relation->content->container !== null) {
                return $relation->content->container;
            }
        }

        return null;
    }

    /**
     * Returns general file infos as array
     * These information are mainly used by the frontend JavaScript application to handle files.
     *
     * @since 1.2
     * @param File $file the file
     * @return array the file infos
     */
    public static function getFileInfos(File $file)
    {
        $thumbnailUrl = '';
        $previewImage = new PreviewImage();
        if ($previewImage->applyFile($file)) {
            $thumbnailUrl = $previewImage->getUrl();
        }

        return [
            'name' => $file->file_name,
            'guid' => $file->guid,
            'size' => $file->size,
            'mimeType' => $file->mime_type,
            'mimeIcon' => MimeHelper::getMimeIconClassByExtension(self::getExtension($file->file_name)),
            'size_format' => Yii::$app->formatter->asShortSize($file->size, 1),
            'url' => $file->getUrl(),
            'relUrl' => $file->getUrl(null, false),
            'openLink' => FileHelper::createLink($file),
            'thumbnailUrl' => $thumbnailUrl
        ];
    }

    /**
     * @inheritdoc
     */
    public static function getExtensionsByMimeType($mimeType, $magicFile = null)
    {
        $extensionsByMimeType = parent::getExtensionsByMimeType($mimeType, $magicFile);

        /* @var Module $module */
        $module = Yii::$app->getModule('file');
        if (isset($module->additionalMimeTypes) && is_array($module->additionalMimeTypes)) {
            foreach ($module->additionalMimeTypes as $additionalExtension => $additionalMimeType) {
                if ($additionalMimeType === $mimeType) {
                    $extensionsByMimeType[] = $additionalExtension;
                }
            }
        }

        return $extensionsByMimeType;
    }

}
