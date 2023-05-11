<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 *
 */

namespace tests\codeception\unit\modules\content;

use an602\modules\content\components\ContentContainerActiveRecord;
use an602\modules\content\models\ContentContainerPermission;
use an602\modules\content\permissions\ManageContent;
use an602\modules\content\tests\codeception\unit\TestContent;
use an602\modules\content\tests\codeception\unit\TestContentManagePermission;
use tests\codeception\_support\an602DbTestCase;
use Codeception\Specify;
use an602\modules\post\models\Post;

use an602\modules\space\models\Space;
use an602\modules\content\models\Content;

class ContentActiveRecordTest extends an602DbTestCase
{

    use Specify;

    public function testConstructor()
    {
        $this->becomeUser('User2');
        $space = Space::findOne(['id' => 2]);

        $post1 = new Post($space, Content::VISIBILITY_PUBLIC);
        $this->assertEquals($space->id, $post1->content->container->id);
        $this->assertEquals(Content::VISIBILITY_PUBLIC, $post1->content->visibility);

        $post2 = new Post($space, Content::VISIBILITY_PRIVATE, ['message' => 'Hello!']);
        $this->assertEquals($space->id, $post2->content->container->id);
        $this->assertEquals(Content::VISIBILITY_PRIVATE, $post2->content->visibility);
        $this->assertEquals('Hello!', $post2->message);

        $post3 = new Post(['message' => 'Hello!']);
        $this->assertEquals('Hello!', $post3->message);
    }

    public function testManagePermission()
    {
        $this->becomeUser('Admin');
        $space = Space::findOne(['id' => 3]);

        $model = new TestContent($space, Content::VISIBILITY_PUBLIC);
        $model->isNewRecord = false;

        $model->setManagePermission([ManageContent::class]);

        $this->becomeUser('User1');

        $this->assertFalse($model->content->canEdit());

        $this->setPermission($space, Space::USERGROUP_MEMBER, new ManageContent, 1);

        $this->assertTrue($model->content->canEdit());

        $model->setManagePermission(new TestContentManagePermission);

        $this->assertFalse($model->content->canEdit());

        $model->setManagePermission([ManageContent::class, TestContentManagePermission::class]);

        $this->assertTrue($model->content->canEdit());
    }

    function setPermission(ContentContainerActiveRecord $contentContianer, $groupId, $permission, $state = 1)
    {
        $groupPermission = new ContentContainerPermission();
        $groupPermission->permission_id = $permission->id;
        $groupPermission->group_id = $groupId;
        $groupPermission->contentcontainer_id = $contentContianer->contentContainerRecord->id;
        $groupPermission->module_id = $permission->moduleId;
        $groupPermission->class = $permission->className();
        $groupPermission->state = $state;
        $groupPermission->save();
        $contentContianer->getPermissionManager()->clear();
    }
}
