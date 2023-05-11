<?php


use an602\components\Migration;
use an602\modules\space\models\Space;

class m150704_005452_namespace extends Migration
{

    public function up()
    {
        $this->renameClass('Space', Space::class);
    }

    public function down()
    {
        echo "m150704_005452_namespace cannot be reverted.\n";

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
