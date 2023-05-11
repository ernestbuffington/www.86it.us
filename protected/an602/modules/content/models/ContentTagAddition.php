<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 *
 */

/**
 * Created by PhpStorm.
 * User: buddha
 * Date: 23.07.2017
 * Time: 21:38
 */

namespace an602\modules\content\models;


use yii\db\ActiveRecord;

/**
 * Class ContentTagAddition
 *
 * @property integer $id
 * @perperty integer $tag_id
 *
 * @since 1.2.2
 * @author buddha
 */
class ContentTagAddition extends ActiveRecord
{
    public function setTag(ContentTag $tag)
    {
        $this->tag_id = $tag->id;
    }
}
