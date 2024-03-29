<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2016 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\file\models;

use an602\modules\file\libs\FileHelper;

/**
 * FileCompat provides an compatibility layer for older an602 Version (1.1 and prior).
 *
 * @since 1.2
 * @author Luke
 */
class FileCompat extends \an602\components\ActiveRecord
{

    /**
     * Returns all files belongs to a given HActiveRecord Object.
     *
     * @deprecated since version 1.2
     * @param \an602\components\ActiveRecord $object
     * @return array of File instances
     */
    public static function getFilesOfObject(\an602\components\ActiveRecord $object)
    {
        return $object->fileManager->findAll();
    }

    /**
     * Returns the path of stored file
     * 
     * @deprecated since version 1.2
     * @param string $suffix
     * @return string path to file
     */
    public function getStoredFilePath($suffix = '')
    {
        return $this->store->get($suffix);
    }

    /**
     * Return the preview image url of the file
     * 
     * @deprecated since version 1.2
     * @param int $maxWidth
     * @param int $maxHeight
     * @return string
     */
    public function getPreviewImageUrl($maxWidth = 1000, $maxHeight = 1000)
    {
        $previewImage = new \an602\modules\file\converter\PreviewImage();
        $previewImage->applyFile($this);
        return $previewImage->getUrl();
    }

    /**
     * Attaches a given list of files to an record (HActiveRecord).
     * This is used when uploading files before the record is created yet.
     *
     * @deprecated since version 1.2
     * @param \yii\db\ActiveRecord $object is a HActiveRecord
     * @param string $files is a comma seperated list of newly uploaded file guids
     * @throws \Exception
     */
    public static function attachPrecreated($object, $files)
    {
        if (!$object instanceof \an602\components\ActiveRecord) {
            throw new \Exception('Invalid object given - require instance of \an602\components\ActiveRecord!');
        }
        $object->fileManager->attach($files);
    }

    /**
     * Returns the filename
     *
     * @deprecated since version 1.2
     * @param string $suffix
     * @return string
     */
    public function getFilename($suffix = "")
    {
        // without prefix
        if ($suffix == "") {
            return $this->file_name;
        }

        $fileParts = pathinfo($this->file_name);

        return $fileParts['filename'] . "_" . $suffix . "." . $fileParts['extension'];
    }

    /**
     * Returns an array with informations about the file
     * 
     * @deprecated since version 1.2
     * @return type
     */
    public function getInfoArray()
    {
        $info = [];

        $info['error'] = false;
        $info['guid'] = $this->guid;
        $info['name'] = $this->file_name;
        $info['title'] = $this->title;
        $info['size'] = $this->size;
        $info['mimeIcon'] = \an602\libs\MimeHelper::getMimeIconClassByExtension($this->getExtension());
        $info['mimeBaseType'] = $this->getMimeBaseType();
        $info['mimeSubType'] = $this->getMimeSubType();
        $info['url'] = $this->getUrl("", false);

        $previewImage = new \an602\modules\file\converter\PreviewImage();
        $previewImage->applyFile($this);
        $info['thumbnailUrl'] = $previewImage->getUrl();

        return $info;
    }

    /**
     * @deprecated since version 1.2
     * @return string
     */
    public function getMimeBaseType()
    {
        if ($this->mime_type != "") {
            list($baseType, $subType) = explode('/', $this->mime_type);
            return $baseType;
        }

        return "";
    }

    /**
     * @deprecated since version 1.2
     * @return string
     */
    public function getMimeSubType()
    {
        if ($this->mime_type != "") {
            list($baseType, $subType) = explode('/', $this->mime_type);
            return $subType;
        }

        return "";
    }

    /**
     * Returns the extension of the file_name
     * 
     * @deprecated since version 1.2
     * @return string the extension
     */
    public function getExtension()
    {
        return FileHelper::getExtension($this->file_name);
    }

}
