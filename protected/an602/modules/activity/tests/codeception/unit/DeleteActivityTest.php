<?php

namespace an602\modules\activity\tests\codeception\unit;

use an602\modules\activity\models\Activity;
use an602\modules\activity\tests\codeception\activities\TestActivity;
use an602\modules\post\models\Post;
use tests\codeception\_support\an602DbTestCase;

class DeleteActivityTest extends an602DbTestCase
{
    public function testDeleteRecord()
    {
        $post = Post::findOne(1);
        $activity = TestActivity::instance()->about($post)->create();
        $record = $activity->record;
        $this->assertNull(Activity::find()->where(['id' => $record->id])->readable()->one());
        $post->delete();
        $this->assertNotNull(Activity::findOne(['id' => $record->id]));
        $this->assertNull(Activity::find()->where(['id' => $record->id])->readable()->one());
        $post->hardDelete();
        $this->assertNull(Activity::findOne(['id' => $record->id]));
    }

    public function testDeleteOriginator()
    {
        $post = Post::findOne(1);
        $activity = TestActivity::instance()->about($post)->create();
        $record = $activity->record;
        $this->assertNotNull(Activity::findOne(['id' => $record->id]));
        $post->createdBy->delete();
        $this->assertNull(Activity::findOne(['id' => $record->id]));
    }
}
