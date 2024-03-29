<?php

namespace tests\codeception\_support;

use Codeception\Configuration;
use Codeception\Exception\ModuleException;
use Codeception\Module;
use Codeception\Module\Yii2;
use an602\models\UrlOembed;
use an602\modules\activity\tests\codeception\fixtures\ActivityFixture;
use an602\modules\content\tests\codeception\fixtures\ContentContainerFixture;
use an602\modules\content\tests\codeception\fixtures\ContentFixture;
use an602\modules\content\widgets\richtext\converter\RichTextToHtmlConverter;
use an602\modules\content\widgets\richtext\converter\RichTextToMarkdownConverter;
use an602\modules\content\widgets\richtext\converter\RichTextToPlainTextConverter;
use an602\modules\content\widgets\richtext\converter\RichTextToShortTextConverter;
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
use TypeError;
use Yii;
use yii\db\ActiveRecord;
use Codeception\Test\Unit;
use an602\libs\BasePermission;
use an602\modules\activity\models\Activity;
use an602\modules\content\components\ContentContainerPermissionManager;
use an602\modules\notification\models\Notification;
use an602\modules\user\components\PermissionManager;
use an602\modules\user\models\User;
use an602\modules\friendship\models\Friendship;
use yii\db\Command;
use yii\db\Exception;
use yii\db\ExpressionInterface;
use yii\db\Query;

/**
 * @SuppressWarnings(PHPMD)
 */
class an602DbTestCase extends Unit
{
    protected $fixtureConfig;

    public $appConfig = '@tests/codeception/config/unit.php';

    public $time;


    protected function setUp(): void
    {
        parent::setUp();

        $webRoot = dirname(__DIR__, 2) . '/../../..';
        Yii::setAlias('@webroot', realpath($webRoot));
        $this->initModules();
        $this->reloadSettings();
        $this->flushCache();
        $this->deleteMails();
    }

    protected function reloadSettings()
    {
        Yii::$app->settings->reload();

        foreach (Yii::$app->modules as $module) {
            if ($module instanceof \an602\components\Module) {
                $module->settings->reload();
            }
        }
    }

    protected function flushCache()
    {
        RichTextToShortTextConverter::flushCache();
        RichTextToHtmlConverter::flushCache();
        RichTextToPlainTextConverter::flushCache();
        RichTextToMarkdownConverter::flushCache();
        UrlOembed::flush();
    }

    protected function deleteMails()
    {
        $path = Yii::getAlias('@runtime/mail');
        $files = glob($path . '/*'); // get all file names
        foreach ($files as $file) { // iterate files
            if (is_file($file)) {
                unlink($file); // delete file
            }
        }
    }

    /**
     * Initializes modules defined in @tests/codeception/config/test.config.php
     * Note the config key in test.config.php is modules and not an602Modules!
     */
    protected function initModules()
    {
        $cfg = Configuration::config();

        if (!empty($cfg['an602_modules'])) {
            Yii::$app->moduleManager->enableModules($cfg['an602_modules']);
        }
    }

    /* @codingStandardsIgnoreLine PSR2.Methods.MethodDeclaration.Underscore */
    public function _fixtures(): array
    {
        $cfg = Configuration::config();

        if (!$this->fixtureConfig && isset($cfg['fixtures'])) {
            $this->fixtureConfig = $cfg['fixtures'];
        }

        $result = [];

        if (!empty($this->fixtureConfig)) {
            foreach ($this->fixtureConfig as $fixtureTable => $fixtureClass) {
                if ($fixtureClass === 'default') {
                    $result = array_merge($result, $this->getDefaultFixtures());
                } else {
                    $result[$fixtureTable] = ['class' => $fixtureClass];
                }
            }
        }

        return $result;
    }

    protected function getDefaultFixtures(): array
    {
        return [
            'user' => ['class' => UserFullFixture::class],
            'url_oembed' => ['class' => UrlOembedFixture::class],
            'group_permission' => ['class' => GroupPermissionFixture::class],
            'contentcontainer' => ['class' => ContentContainerFixture::class],
            'settings' => ['class' => SettingFixture::class],
            'space' => ['class' => SpaceFixture::class],
            'space_membership' => ['class' => SpaceMembershipFixture::class],
            'content' => ['class' => ContentFixture::class],
            'notification' => ['class' => NotificationFixture::class],
            'file' => ['class' => FileFixture::class],
            'file_history' => ['class' => FileHistoryFixture::class],
            'activity' => ['class' => ActivityFixture::class],
            'friendship' => ['class' => FriendshipFixture::class],
            'live' => [ 'class' => LiveFixture::class]
        ];
    }

    public function assertHasNotification($class, ActiveRecord $source, $originator_id = null, $target_id = null, $msg = '')
    {
        $notificationQuery = Notification::find()->where([
            'class' => $class,
            'source_class' => $source->className(),
            'source_pk' => $source->getPrimaryKey(),
        ]);
        if (is_string($target_id)) {
            $msg = $target_id;
            $target_id = null;
        }

        if ($originator_id != null) {
            $notificationQuery->andWhere(['originator_user_id' => $originator_id]);
        }

        if ($target_id != null) {
            $notificationQuery->andWhere(['user_id' => $target_id]);
        }

        $this->assertNotEmpty($notificationQuery->all(), $msg);
    }

    public function assertEqualsNotificationCount($count, $class, ActiveRecord $source, $originator_id = null, $target_id = null, $msg = '')
    {
        $notificationQuery = Notification::find()->where(['class' => $class, 'source_class' => $source->className(), 'source_pk' => $source->getPrimaryKey()]);

        if ($originator_id != null) {
            $notificationQuery->andWhere(['originator_user_id' => $originator_id]);
        }

        if ($target_id != null) {
            $notificationQuery->andWhere(['user_id' => $target_id]);
        }

        $this->assertEquals($count, $notificationQuery->count(), $msg);
    }

    public function assertHasNoNotification($class, ActiveRecord $source, $originator_id = null, $target_id = null, $msg = '')
    {
        $notificationQuery = Notification::find()->where(['class' => $class, 'source_class' => $source->className(), 'source_pk' => $source->getPrimaryKey()]);

        if ($originator_id != null) {
            $notificationQuery->andWhere(['originator_user_id' => $originator_id]);
        }

        if ($target_id != null) {
            $notificationQuery->andWhere(['user_id' => $target_id]);
        }

        $this->assertEmpty($notificationQuery->all(), $msg);
    }

    public function assertHasActivity($class, ActiveRecord $source, $msg = '')
    {
        $activity = Activity::findOne([
            'class' => $class,
            'object_model' => $source->className(),
            'object_id' => $source->getPrimaryKey(),
        ]);
        $this->assertNotNull($activity, $msg);
    }

    /**
     * @return Yii2|Module
     * @throws ModuleException
     */
    public function getYiiModule()
    {
        return $this->getModule('Yii2');
    }

    /**
     * @see assertSentEmail
     * @since 1.3
     */
    public function assertMailSent($count = 0)
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $this->getYiiModule()->seeEmailIsSent($count);
    }

    /**
     * @param int $count
     *
     * @throws ModuleException
     * @since 1.3
     */
    public function assertSentEmail(int $count = 0)
    {
        $this->getYiiModule()->seeEmailIsSent($count);
    }

    public function assertEqualsLastEmailTo($to, $strict = true)
    {
        if (is_string($to)) {
            $to = [$to];
        }

        /** @noinspection PhpUnhandledExceptionInspection */
        $message = $this->getYiiModule()->grabLastSentEmail();
        $expected = $message->getTo();

        foreach ($to as $email) {
            $this->assertArrayHasKey($email, $expected);
        }

        if ($strict) {
            $this->assertCount(count($expected), $to);
        }
    }

    public function assertEqualsLastEmailSubject($subject)
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $message = $this->getYiiModule()->grabLastSentEmail();
        $this->assertEquals($subject, str_replace(["\n", "\r"], '', $message->getSubject()));
    }

    /**
     * @param int|null $expected Number of records expected. Null for any number, but not none
     * @param string|array|ExpressionInterface $tables
     * @param string|array|ExpressionInterface|null $condition
     * @param array|null $params
     * @param string $message
     *
     * @return void
     * @since 1.15
     */
    public function assertRecordCount(?int $expected, $tables, $condition = null, ?array $params = [], string $message = ''): void
    {
        $count = $this->dbCount($tables, $condition, $params ?? []);

        if ($expected === null) {
            $this->assertGreaterThan(0, $count, $message);
        } else {
            $this->assertEquals($expected, $count, $message);
        }
    }

    /**
     * @param string|array|ExpressionInterface $tables
     * @param string|array|ExpressionInterface|null $condition
     * @param array|null $params
     * @param string $message
     *
     * @return void
     * @since 1.15
     */
    public function assertRecordExistsAny($tables, $condition = null, ?array $params = [], string $message = 'Record does not exist'): void
    {
        $this->assertRecordCount(null, $tables, $condition, $params ?? [], $message);
    }

    /**
     * @param string|array|ExpressionInterface $tables
     * @param string|array|ExpressionInterface|null $condition
     * @param array|null $params
     * @param string $message
     *
     * @return void
     * @since 1.15
     */
    public function assertRecordExists($tables, $condition = null, ?array $params = [], string $message = 'Record does not exist'): void
    {
        $this->assertRecordCount(1, $tables, $condition, $params ?? [], $message);
    }

    /**
     * @param string|array|ExpressionInterface $tables
     * @param string|array|ExpressionInterface|null $condition
     * @param array|null $params
     * @param string $message
     *
     * @return void
     * @since 1.15
     */
    public function assertRecordNotExists($tables, $condition = null, ?array $params = [], string $message = 'Record exists'): void
    {
        $this->assertRecordCount(0, $tables, $condition, $params ?? [], $message);
    }

    /**
     * @param int|string|null $expected Number of records expected. Null for any number, but not none
     * @param string $column
     * @param string|array|ExpressionInterface $tables
     * @param string|array|ExpressionInterface|null $condition
     * @param array|null $params
     * @param string $message
     *
     * @return void
     * @since 1.15
     */
    public function assertRecordValue($expected, string $column, $tables, $condition = null, ?array $params = [], string $message = ''): void
    {
        $value = $this->dbQuery($tables, $condition, $params, 1)->select($column)->scalar();
        $this->assertEquals($expected, $value, $message);
    }

    public function expectExceptionTypeError(string $calledClass, string $method, int $argumentNumber, string $argumentName, string $expectedType, string $givenTye, string $exceptionClass = TypeError::class): void
    {
        $this->expectException($exceptionClass);

        $calledClass = str_replace('\\', '\\\\', $calledClass);
        $argumentName = ltrim($argumentName, '$');

        $this->expectExceptionMessageRegExp(
            sprintf(
            // Php < 8 uses: "Argument n passed to class::method() ..."
            // PHP > 7 uses: "class::method(): Argument #n ($argument) ..."
                '@^((Argument %d passed to )?%s::%s\\(\\)(?(2)|: Argument #%d \\(\\$%s\\))) must be of( the)? type %s, %s given, called in /.*@',
                $argumentNumber,
                $calledClass,
                $method,
                $argumentNumber,
                $argumentName,
                $expectedType,
                $givenTye
            )
        );
    }

    /**
     * @param bool $allow
     */
    public function allowGuestAccess(bool $allow = true)
    {
        Yii::$app
            ->getModule('user')
            ->settings
            ->set('auth.allowGuestAccess', (int)$allow);
    }

    public function setProfileField($field, $value, $user)
    {
        if (is_int($user)) {
            $user = User::findOne($user);
        } elseif (is_string($user)) {
            $user = User::findOne(['username' => $user]);
        } elseif (!$user) {
            $user = Yii::$app->user->identity;
        }

        $user->profile->setAttributes([$field => $value]);
        $user->profile->save();
    }

    public function becomeFriendWith($username)
    {
        $user = User::findOne(['username' => $username]);
        Friendship::add($user, Yii::$app->user->identity);
        Friendship::add(Yii::$app->user->identity, $user);
    }

    public function follow($username)
    {
        User::findOne(['username' => $username])->follow();
    }

    public function enableFriendships($enable = true)
    {
        Yii::$app->getModule('friendship')->settings->set('enable', $enable);
    }

    public function setGroupPermission($groupId, $permission, $state = BasePermission::STATE_ALLOW)
    {
        $permissionManger = new PermissionManager();
        $permissionManger->setGroupState($groupId, $permission, $state);
        Yii::$app->user->permissionManager->clear();
    }

    public function setContentContainerPermission(
        $contentContainer,
        $groupId,
        $permission,
        $state = BasePermission::STATE_ALLOW
    ) {
        $permissionManger = new ContentContainerPermissionManager(['contentContainer' => $contentContainer]);
        $permissionManger->setGroupState($groupId, $permission, $state);
        $contentContainer->permissionManager->clear();
    }

    public function becomeUser($userName): ?User
    {
        $user = User::findOne(['username' => $userName]);
        Yii::$app->user->switchIdentity($user);
        return $user;
    }

    public function logout()
    {
        Yii::$app->user->logout();
    }

    /**
     * @see \yii\db\Connection::createCommand()
     * @since 1.15
     */
    public function dbCommand($sql = null, $params = []): Command
    {
        return Yii::$app->getDb()->createCommand($sql, $params);
    }

    /**
     * @param Command $cmd
     * @param bool $execute
     *
     * @return Command
     * @throws Exception
     */
    protected function dbCommandExecute(Command $cmd, bool $execute = true): Command
    {
        if ($execute) {
            $cmd->execute();
        }

        return $cmd;
    }

    /**
     * @see Query
     * @since 1.15
     */
    public function dbQuery($tables, $condition, $params = [], $limit = 10): Query
    {
        return (new Query())
            ->from($tables)
            ->where($condition, $params)
            ->limit($limit);
    }

    /**
     * @see Command::insert
     * @since 1.15
     */
    public function dbInsert($table, $columns, bool $execute = true): Command
    {
        return $this->dbCommandExecute($this->dbCommand()->insert($table, $columns), $execute);
    }

    /**
     * @see Command::update
     * @since 1.15
     */
    public function dbUpdate($table, $columns, $condition = '', $params = [], bool $execute = true): Command
    {
        return $this->dbCommandExecute($this->dbCommand()->update($table, $columns, $condition, $params), $execute);
    }

    /**
     * @see Command::upsert
     * @since 1.15
     */
    public function dbUpsert($table, $insertColumns, $updateColumns = true, $params = [], bool $execute = true): Command
    {
        return $this->dbCommandExecute($this->dbCommand()->upsert($table, $insertColumns, $updateColumns, $params), $execute);
    }

    /**
     * @see Command::delete()
     * @since 1.15
     */
    public function dbDelete($table, $condition = '', $params = [], bool $execute = true): Command
    {
        return $this->dbCommandExecute($this->dbCommand()->delete($table, $condition, $params), $execute);
    }

    /**
     * @see Query::select
     * @see Query::from
     * @see Query::where
     * @see \yii\db\QueryTrait::limit()
     * @since 1.15
     */
    public function dbSelect($tables, $columns, $condition = '', $params = [], $limit = 10, $selectOption = null): array
    {
        return $this->dbQuery($tables, $condition, $params, $limit)
            ->select($columns, $selectOption)
            ->all();
    }

    /**
     * @see Command::delete()
     * @since 1.15
     */
    public function dbCount($tables, $condition = '', $params = [])
    {
        return $this->dbQuery($tables, $condition, $params)
            ->select("count(*)")
            ->scalar();
    }
}
