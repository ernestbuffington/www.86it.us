<?php


use yii\db\Migration;
use an602\modules\content\permissions\CreatePublicContent;

class m160221_222312_public_permission_change extends Migration
{

    public function up()
    {
        $this->update('contentcontainer_permission', [
            'permission_id' => CreatePublicContent::class,
            'class' => CreatePublicContent::class,
            'module_id' => 'content'
                ], [
            'permission_id' => 'an602\modules\space\permissions\CreatePublicContent',
            'class' => 'an602\modules\space\permissions\CreatePublicContent',
            'module_id' => 'space',
        ]);
    }

    public function down()
    {
        echo "m160221_222312_public_permission_change cannot be reverted.\n";

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
