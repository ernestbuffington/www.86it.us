<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2015 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\user\models;

use an602\components\ActiveRecord;

/**
 * This is the model class for table "user_http_session".
 *
 * The followings are the available columns in table 'user_http_session':
 * @property string $id
 * @property integer $expire
 * @property integer $user_id
 * @property string $data
 *
 * @package an602.modules_core.user.models
 * @since 0.5
 * @author Luke
 */
class Session extends ActiveRecord
{

    /**
     * @return string the associated database table name
     */
    public static function tableName()
    {
        return 'user_http_session';
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

}
