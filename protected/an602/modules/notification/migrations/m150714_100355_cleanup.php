<?php


use yii\db\Migration;

class m150714_100355_cleanup extends Migration
{

    public function up()
    {
        $this->dropColumn('notification', 'obsolete_target_object_model');
        $this->dropColumn('notification', 'obsolete_target_object_id');
        $this->dropColumn('notification', 'created_by');
        $this->dropColumn('notification', 'updated_by');
        $this->dropColumn('notification', 'updated_at');
        $this->addColumn('notification', 'module', "varchar(100) DEFAULT ''");

        $this->update('notification', ['module' => 'admin'], ['class' => 'an602\modules\admin\notifications\NewVersionAvailable']);
        $this->update('notification', ['module' => 'comment'], ['class' => 'an602\modules\comment\notifications\NewComment']);
        $this->update('notification', ['module' => 'content'], ['class' => 'an602\modules\content\notifications\ContentCreated']);
        $this->update('notification', ['module' => 'like'], ['class' => 'an602\modules\like\notifications\NewLike']);
        $this->update('notification', ['module' => 'space'], ['class' => 'an602\modules\space\notifications\NewLike']);
        $this->update('notification', ['module' => 'space'], ['class' => 'an602\modules\space\notifications\ApprovalRequest']);
        $this->update('notification', ['module' => 'space'], ['class' => 'an602\modules\space\notifications\ApprovalRequestAccepted']);
        $this->update('notification', ['module' => 'space'], ['class' => 'an602\modules\space\notifications\ApprovalRequestDeclined']);
        $this->update('notification', ['module' => 'space'], ['class' => 'an602\modules\space\notifications\Invite']);
        $this->update('notification', ['module' => 'space'], ['class' => 'an602\modules\space\notifications\InviteAccepted']);
        $this->update('notification', ['module' => 'space'], ['class' => 'an602\modules\space\notifications\InviteDeclined']);
        $this->update('notification', ['module' => 'user'], ['class' => 'an602\modules\user\notifications\Followed']);
        $this->update('notification', ['module' => 'user'], ['class' => 'an602\modules\user\notifications\Mentioned']);
    }

    public function down()
    {
        echo "m150714_100355_cleanup cannot be reverted.\n";

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
