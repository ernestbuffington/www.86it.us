<?php

namespace an602\modules\activity\tests\codeception\unit;

use an602\modules\activity\tests\codeception\activities\TestActivityDefaultLayout;
use an602\modules\activity\tests\codeception\activities\TestViewActivity;
use an602\modules\activity\tests\codeception\activities\TestActivity;
use an602\modules\content\widgets\stream\StreamEntryWidget;
use an602\modules\post\models\Post;
use an602\modules\user\models\User;
use tests\codeception\_support\an602DbTestCase;

class ActivityViewTest extends an602DbTestCase
{
    public function testRenderStreamEntryWithActivityView()
    {
        $activity = TestViewActivity::instance()->from(User::findOne(['id' => 1]))
            ->about(Post::findOne(['id' => 1]))->create();

        $this->assertNotNull($activity->record);
        $wallout = StreamEntryWidget::renderStreamEntry($activity->record);
        $this->assertStringContainsString('My special activity view layout', $wallout);
        $this->assertStringContainsString('My special activity view content', $wallout);
    }

    public function testRenderStreamEntryWithActivityWithoutView()
    {
        $activity = TestActivity::instance()->from(User::findOne(['id' => 1]))
            ->about(Post::findOne(['id' => 1]))->create();

        $this->assertNotNull($activity->record);
        $wallout = StreamEntryWidget::renderStreamEntry($activity->record);
        $this->assertStringContainsString('My special activity view layout without view', $wallout);
        $this->assertStringContainsString('Content of no view activity', $wallout);
    }

    public function testRenderWithoutLayoutAndView()
    {
        $activity = TestActivityDefaultLayout::instance()->from(User::findOne(['id' => 1]))
            ->about(Post::findOne(['id' => 1]))->create();

        $this->assertNotNull($activity->record);
        $wallout = StreamEntryWidget::renderStreamEntry($activity->record);
        $this->assertStringContainsString('Content of default layout activity', $wallout);
        $this->assertStringContainsString('media-object img-rounded', $wallout);
    }
}
