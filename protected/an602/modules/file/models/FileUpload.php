<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2016 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\file\models;

use yii\web\UploadedFile;
use an602\modules\file\validators\FileValidator;

/**
 * FileUpload model is used for File uploads handled by the UploadAction via ajax.
 *
 * @see \an602\modules\file\actions\UploadAction
 * @author Luke
 * @inheritdoc
 * @since 1.2
 */
class FileUpload extends File
{

    /**
     * @var UploadedFile the uploaded file
     */
    public $uploadedFile = null;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = [
            [['uploadedFile'], FileValidator::class],
        ];

        return array_merge(parent::rules(), $rules);
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        // Store file
        if ($this->uploadedFile !== null && $this->uploadedFile instanceof UploadedFile) {
            $this->setStoredFile($this->uploadedFile);
        }

        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * Sets uploaded file to this file model
     *
     * @param UploadedFile $uploadedFile
     */
    public function setUploadedFile(UploadedFile $uploadedFile)
    {
        // Set Filename
        $filename = $uploadedFile->getBaseName();
        $extension = $uploadedFile->getExtension();
        if ($extension !== '') {
            $filename .= '.' . $extension;
        }

        $this->file_name = $filename;
        $this->mime_type = $uploadedFile->type;
        $this->size = $uploadedFile->size;
        $this->uploadedFile = $uploadedFile;
    }

}
