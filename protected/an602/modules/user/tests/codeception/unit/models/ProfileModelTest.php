<?php

namespace tests\codeception\unit\models;

use an602\modules\user\models\Profile;
use an602\modules\user\models\ProfileField;
use an602\modules\user\models\ProfileFieldCategory;
use an602\modules\user\models\User;
use tests\codeception\_support\an602DbTestCase;

class ProfileModelTest extends an602DbTestCase
{
    public function testReturnTableName()
    {
        $this->assertEquals('profile', Profile::tableName());
    }

    public function testReturnScenarios()
    {
        $model = new Profile();
        $scenarios = $model->scenarios();
        $this->assertTrue(key_exists(Profile::SCENARIO_EDIT_ADMIN, $scenarios));
        $this->assertTrue(key_exists(Profile::SCENARIO_REGISTRATION, $scenarios));
        $this->assertTrue(key_exists(Profile::SCENARIO_EDIT_PROFILE, $scenarios));
    }

    public function testReturnArrayOfAttributeLabels()
    {
        $model = new Profile();
        $this->assertTrue(is_array($model->attributeLabels()));
    }

    public function testReturnArrayOfFormDefinition()
    {
        $model = new Profile();
        $this->assertTrue(is_array($model->getFormDefinition()));
    }

    public function testReturnArrayOfProfileFieldCategories()
    {
        $categories = ProfileFieldCategory::find()->all();

        $profile = User::findOne(['username' => 'Admin'])->profile;
        $profile->mobile = '11111111';
        $profile->url = 'http://test-url.com';
        $profile->save();
        $this->assertTrue(is_array($profile->getProfileFieldCategories()));

        $this->assertEquals(count($categories), count($profile->getProfileFieldCategories()));
    }
}
