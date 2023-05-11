<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.an602.org/licences
 */

use yii\db\Migration;

class m171027_220519_exclusive_jobs extends Migration
{
    public $tableName = '{{queue_exclusive}}';

    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->string(50)->notNull(),
            'job_message_id' => $this->string(50),
            'job_status' => $this->smallInteger()->defaultValue(2),
            'last_update' => $this->timestamp()
        ]);
        $this->addPrimaryKey('pk_queue_exclusive', $this->tableName, 'id');
    }

    public function safeDown()
    {
        echo "m171027_220519_exclusive_jobs cannot be reverted.\n";

        return false;
    }
}
