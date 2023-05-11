<?php

namespace tests\codeception\_support;

use Codeception\Module;
use an602\modules\activity\tests\codeception\fixtures\ActivityFixture;
use an602\modules\content\tests\codeception\fixtures\ContentContainerSettingFixture;
use an602\modules\content\tests\codeception\fixtures\ContentFixture;
use an602\modules\file\models\FileHistory;
use an602\modules\file\tests\codeception\fixtures\FileFixture;
use an602\modules\file\tests\codeception\fixtures\FileHistoryFixture;
use an602\modules\friendship\tests\codeception\fixtures\FriendshipFixture;
use an602\modules\live\tests\codeception\fixtures\LiveFixture;
use an602\modules\notification\tests\codeception\fixtures\NotificationFixture;
use an602\modules\space\tests\codeception\fixtures\SpaceFixture;
use an602\modules\space\tests\codeception\fixtures\SpaceMembershipFixture;
use an602\modules\user\tests\codeception\fixtures\GroupPermissionFixture;
use an602\modules\user\tests\codeception\fixtures\UserFullFixture;
use an602\tests\codeception\fixtures\SettingFixture;
use an602\tests\codeception\fixtures\UrlOembedFixture;
use yii\test\FixtureTrait;
use yii\test\InitDbFixture;

/**
 * This helper is used to populate the database with needed fixtures before any tests are run.
 * In this example, the database is populated with the demo login user, which is used in acceptance
 * and functional tests.  All fixtures will be loaded before the suite is started and unloaded after it
 * completes.
 */
class DynamicFixtureHelper extends Module
{

    public $beforeTest = true;

    /**
     * Redeclare visibility because codeception includes all public methods that do not start with "_"
     * and are not excluded by module settings, in actor class.
     */
    use FixtureTrait {
        loadFixtures as public;
        fixtures as public;
        globalFixtures as public;
        createFixtures as public;
        unloadFixtures as protected;
        getFixtures as protected;
        getFixture as protected;
    }

    public function _beforeSuite($settings = [])
    {

        //Prevents [ReflectionException] Class db does not exist for included module tests
        include __DIR__ . '/../functional/_bootstrap.php';

        if (!$this->beforeTest) {
            $this->loadFixtures();
        }
    }

     public function _afterSuite($settings = [])
    {
        if (!$this->beforeTest) {
            $this->unloadFixtures();
        }
    }

    /**
     * Method called before any suite tests run. Loads User fixture login user
     * to use in acceptance and functional tests.
     * @param array $settings
     */
    public function _before(\Codeception\TestCase $test)
    {
        $this->unloadFixtures();

        if ($this->beforeTest) {
            $this->loadFixtures();
        }
    }

    /**
     * Method is called after all suite tests run
     */
    public function _after(\Codeception\TestCase $test)
    {
        if ($this->beforeTest) {
            //$this->unloadFixtures();
        }
    }

    /**
     * @inheritdoc
     */
    public function globalFixtures()
    {
        return [
            InitDbFixture::class,
        ];
    }

    /**
     * @inheritdoc
     */
    public function fixtures()
    {
        $result = [];

        $cfg = \Codeception\Configuration::config();
        if (isset($cfg['fixtures'])) {
            foreach ($cfg['fixtures'] as $fixtureTable => $fixtureClass) {
                if ($fixtureClass === 'default') {
                    $result = array_merge($result, $this->getDefaultFixtures());
                } else {
                    $result[$fixtureTable] = ['class' => $fixtureClass];
                }
            }
        }

        return $result;
    }

    protected function getDefaultFixtures()
    {
        return [
            'user' => ['class' => UserFullFixture::class],
            'url_oembed' => ['class' => UrlOembedFixture::class],
            'group_permission' => ['class' => GroupPermissionFixture::class],
            'settings' => ['class' => SettingFixture::class],
            'contentcontainer_settings' => ['class' => ContentContainerSettingFixture::class],
            'space' => [ 'class' => SpaceFixture::class],
            'space_membership' => [ 'class' => SpaceMembershipFixture::class],
            'content' => ['class' => ContentFixture::class],
            'file' => ['class' => FileFixture::class],
            'file_history' => ['class' => FileHistoryFixture::class],
            'notification' => [ 'class' => NotificationFixture::class],
            'activity' => [ 'class' => ActivityFixture::class],
            'friendship' => ['class' => FriendshipFixture::class],
            'live' => ['class' => LiveFixture::class]
        ];
    }
}
