<?php

/**
 * This file used for enhanced IDE code autocompletion only.
 * NOTE: To avoid warning of multiple autocompletion you should mark the file protected\vendor\yiisoft\yii2\Yii.php
 * as a plain text file for your IDE
 * @see https://github.com/samdark/yii2-cookbook/blob/master/book/ide-autocompletion.md#using-custom-yii-class
 */
class Yii extends \yii\BaseYii
{
    /**
     * @var BaseApplication|WebApplication|ConsoleApplication the application instance
     */
    public static $app;
}

/**
 * Class BaseApplication
 * Used for properties that are identical for both WebApplication and ConsoleApplication
 * @property-read \an602\components\ModuleManager $moduleManager
 * @property-read \an602\components\Controller $controller
 * @property-read \an602\components\i18n\I18N $i18n
 * @property-read \an602\components\mail\Mailer $mailer
 * @property-read \an602\modules\ui\view\components\View $view
 * @property-read \an602\components\SettingsManager $settings
 * @property-read \an602\modules\notification\components\NotificationManager $notification
 * @property-read \an602\modules\search\engine\Search $search
 * @property-read \an602\components\i18n\Formatter
 * @property-read \an602\components\AssetManager $assetManager
 * @property-read \an602\modules\user\authclient\Collection $authClientCollection
 * @property-read \yii\queue\Queue $queue
 * @property-read \an602\components\Request $request
 * @property-read \an602\components\UrlManager $urlManager
 * @property-read \an602\modules\live\components\Sender $live
 * @property-read \yii\mutex\Mutex $mutex
 *
 */
abstract class BaseApplication extends yii\base\Application
{
}

/**
 * Class WebApplication
 * Include only Web application related components here
 * @property-read \an602\modules\user\components\User $user
 * @property-read \an602\components\mail\Mailer $mailer
 */
class WebApplication extends \an602\components\Application
{
}

/**
 * Class ConsoleApplication
 * Include only Console application related components here
 */
class ConsoleApplication extends \an602\components\console\Application
{
}
