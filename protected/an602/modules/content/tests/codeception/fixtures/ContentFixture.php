<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2015 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\content\tests\codeception\fixtures;

use yii\test\ActiveFixture;

class ContentFixture extends ActiveFixture
{

    public $modelClass = 'an602\modules\content\models\Content';
    public $dataFile = '@modules/content/tests/codeception/fixtures/data/content.php';
    
    public $depends = [
        'an602\modules\content\tests\codeception\fixtures\ContentContainerFixture',
        'an602\modules\content\tests\codeception\fixtures\ContentTagFixture',
        'an602\modules\content\tests\codeception\fixtures\ContentTagRelationFixture',
        'an602\modules\content\tests\codeception\fixtures\ContentContainerTagFixture',
        'an602\modules\content\tests\codeception\fixtures\ContentContainerTagRelationFixture',
        'an602\modules\post\tests\codeception\fixtures\PostFixture',
        'an602\modules\comment\tests\codeception\fixtures\CommentFixture',
        'an602\modules\like\tests\codeception\fixtures\LikeFixture'
    ];

}
