<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2018 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

use yii\db\Migration;

class m180315_112748_fix_email_length extends Migration
{
    public function safeUp()
    {
        $this->alterColumn('user', 'email', $this->char(150)->null());
        $this->alterColumn('user_invite', 'email', $this->char(150)->notNull());
    }

    public function safeDown()
    {
        echo "m180315_112748_fix_email_length cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180315_112748_fix_email_length cannot be reverted.\n";

        return false;
    }
    */
}
