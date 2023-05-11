<?php
namespace an602\modules\activity\tests\codeception\fixtures;

use yii\test\ActiveFixture;
use an602\modules\activity\models\Activity;

class ActivityFixture extends ActiveFixture
{
    public $modelClass = Activity::class;
    public $dataFile = '@modules/activity/tests/codeception/fixtures/data/activity.php';
}
