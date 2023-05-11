<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.an602.org/licences
 */

use yii\db\Migration;

class m171025_142030_queue_update extends Migration
{
    public $tableName = '{{%queue}}';

    public function safeUp()
    {
        $tableSchema = Yii::$app->db->schema->getTableSchema($this->tableName);

        if ($tableSchema !== null) {
            $this->dropTable($this->tableName);
        }

        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'channel' => $this->string(50)->notNull(),
            'job' => $this->binary()->notNull(),
            'pushed_at' => $this->integer()->notNull(),
            'ttr' => $this->integer()->notNull(),
            'delay' => $this->integer()->notNull(),
            'priority' => $this->integer()->unsigned()->notNull()->defaultValue(1024),
            'reserved_at' => $this->integer(),
            'attempt' => $this->integer(),
            'done_at' => $this->integer(),
        ]);

        $this->createIndex('channel', $this->tableName, 'channel');
        $this->createIndex('reserved_at', $this->tableName, 'reserved_at');
        $this->createIndex('priority', $this->tableName, 'priority');
    }

    public function safeDown()
    {
        echo "m171025_142030_queue_update cannot be reverted.\n";

        return false;
    }
}
