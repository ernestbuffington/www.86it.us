<?php


use an602\components\Migration;
use an602\modules\post\models\Post;

class m150704_005338_namespace extends Migration
{
    public function up()
    {
        $this->renameClass('Post', Post::class);
    }

    public function down()
    {
        echo "m150704_005338_namespace cannot be reverted.\n";

        return false;
    }
    
    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }
    
    public function safeDown()
    {
    }
    */
}
