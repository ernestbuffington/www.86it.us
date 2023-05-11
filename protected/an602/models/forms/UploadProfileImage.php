<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\models\forms;

use Yii;
use yii\base\Model;

/**
 * UploadProfileImageForm allows uploads of profile images.
 *
 * Profile images will used by spaces or users.
 *
 * @package an602.forms
 * @since 0.5
 */
class UploadProfileImage extends Model
{

    /**
     * @var String uploaded image
     */
    public $image;

    /**
     * Declares the validation rules.
     *
     * @return Array Validation Rules
     */
    public function rules()
    {
        return [
            ['image', 'required'],
            ['image', 'file', 'extensions' => 'jpg, jpeg, png, tiff', 'maxSize' => Yii::$app->getModule('file')->settings->get('maxFileSize')],
        ];
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return [
            'image' => Yii::t('base', 'New profile image'),
        ];
    }

}
