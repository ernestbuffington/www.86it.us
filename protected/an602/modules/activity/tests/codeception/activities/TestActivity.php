<?php

namespace an602\modules\activity\tests\codeception\activities;

use Yii;
use yii\helpers\Url;

/**
 * Description of TestActivity
 *
 * @author buddha
 */
class TestActivity extends \an602\modules\activity\components\BaseActivity {

    public $moduleId = 'test';

    public $viewName = 'testNoView';

    public function html()
    {
        return 'Content of no view activity';
    }

    public function getUrl()
    {
        return Url::toRoute(['/user/account/edit']);
    }
}
