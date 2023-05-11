<?php

namespace an602\modules\activity\tests\codeception\activities;

use Yii;
use yii\helpers\Url;

/**
 * Description of TestActivity
 *
 * @author buddha
 */
class TestActivityDefaultLayout extends \an602\modules\activity\components\BaseActivity {

    public $moduleId = 'test';

    public function html()
    {
        return 'Content of default layout activity';
    }
}
