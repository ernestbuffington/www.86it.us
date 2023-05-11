<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\queue\models;

/**
 * This is the model class for table "queue_exclusive".
 *
 * @property string $id
 * @property string $job_message_id
 * @property integer $job_status
 * @property string $last_update
 */
class QueueExclusive extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'queue_exclusive';
    }

}
