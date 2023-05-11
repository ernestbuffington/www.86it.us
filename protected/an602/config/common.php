<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

use an602\components\i18n\PhpMessageSource;

Yii::setAlias('@webroot', realpath(__DIR__ . '/../../../'));
Yii::setAlias('@app', '@webroot/protected');
Yii::setAlias('@an602', '@app/an602');
Yii::setAlias('@config', '@app/config');
Yii::setAlias('@themes', '@webroot/themes');

// Workaround: PHP 7.3 compatible ZF2 ArrayObject class
Yii::$classMap['Zend\Stdlib\ArrayObject'] = '@an602/compat/ArrayObject.php';

// Workaround: If OpenSSL extension is not available (#3852)
if (!defined('PKCS7_DETACHED')) {
    define('PKCS7_DETACHED', 64);
}

$config = [
    'name' => 'an602',
    'version' => '1.15.0-dev',
    'minRecommendedPhpVersion' => '7.4',
    'minSupportedPhpVersion' => '7.4',
    'basePath' => dirname(__DIR__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR,
    'bootstrap' => ['log', 'an602\components\bootstrap\ModuleAutoLoader', 'queue', 'an602\modules\ui\view\bootstrap\ThemeLoader'],
    'sourceLanguage' => 'en',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/php-an602/npm-asset',
        '@filestore' => '@webroot/uploads/file',
    ],
    'components' => [
        'moduleManager' => [
            'class' => \an602\components\ModuleManager::class
        ],
        'notification' => [
            'class' => \an602\modules\notification\components\NotificationManager::class,
            'targets' => [
                \an602\modules\notification\targets\WebTarget::class => [
                    'renderer' => ['class' => \an602\modules\notification\renderer\WebRenderer::class]
                ],
                \an602\modules\notification\targets\MailTarget::class => [
                    'renderer' => ['class' => \an602\modules\notification\renderer\MailRenderer::class]
                ],
                \an602\modules\notification\targets\MobileTarget::class => []
            ]
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                \yii\log\FileTarget::class => [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                    'except' => [
                        'yii\web\HttpException:400', 'yii\web\HttpException:401', 'yii\web\HttpException:403',
                        'yii\web\HttpException:404', 'yii\web\HttpException:405',
                        'yii\web\User::getIdentityAndDurationFromCookie', 'yii\web\User::renewAuthStatus'
                    ],
                    'logVars' => ['_GET', '_SERVER'],
                ],
                \yii\log\DbTarget::class =>[
                    'class' => \yii\log\DbTarget::class,
                    'levels' => ['error', 'warning'],
                    'except' => [
                        'yii\web\HttpException:400', 'yii\web\HttpException:401', 'yii\web\HttpException:403',
                        'yii\web\HttpException:404', 'yii\web\HttpException:405',
                        'yii\web\User::getIdentityAndDurationFromCookie', 'yii\web\User::renewAuthStatus'
                    ],
                    'logVars' => ['_GET', '_SERVER'],
                ],
            ],
        ],
        'search' => [
            'class' => \an602\modules\search\engine\ZendLuceneSearch::class,
        ],
        'settings' => [
            'class' => \an602\components\SettingsManager::class,
            'moduleId' => 'base',
        ],
        'i18n' => [
            'class' => \an602\components\i18n\I18N::class,
            'translations' => [
                'base' => [
                    'class' => PhpMessageSource::class,
                    'basePath' => '@an602/messages'
                ],
                'error' => [
                    'class' => PhpMessageSource::class,
                    'basePath' => '@an602/messages'
                ],
                'an602.yii' => [
                    'class' => PhpMessageSource::class,
                    'basePath' => '@an602/messages'
                ],
                'custom' => [
                    'class' => PhpMessageSource::class,
                    'basePath' => '@an602/messages'
                ],
            ],
        ],
        'formatter' => [
            'class' => \an602\components\i18n\Formatter::class,
        ],
        'cache' => [
            'class' => \yii\caching\DummyCache::class,
        ],
        'mailer' => [
            'class' => \an602\components\mail\Mailer::class,
            'viewPath' => '@an602/views/mail',
            'view' => [
                'class' => \yii\web\View::class,
                'theme' => [
                    'class' => \an602\modules\ui\view\components\Theme::class,
                    'name' => 'an602'
                ],
            ],
        ],
        'assetManager' => [
            'class' => \an602\components\AssetManager::class,
            'appendTimestamp' => true,
            'bundles' => require(__DIR__ . '/' . (YII_ENV_PROD || YII_ENV_TEST ? 'assets-prod.php' : 'assets-dev.php')),
        ],
        'view' => [
            'class' => \an602\modules\ui\view\components\View::class,
            'theme' => [
                'class' => \an602\modules\ui\view\components\Theme::class,
                'name' => 'an602',
            ],
        ],
        'db' => [
            'class' => \yii\db\Connection::class,
            // Fix for MySQL 8.0.21+: https://github.com/yiisoft/yii2/issues/18207
            'schemaMap' => [
                'mysqli' => 'an602\components\db\MysqlSchema',
                'mysql' => 'an602\components\db\MysqlSchema'
            ],
            'dsn' => 'mysql:host=localhost;dbname=an602',
            'username' => '',
            'password' => '',
            'charset' => 'utf8mb4',
            'enableSchemaCache' => true,
            'on afterOpen' => ['an602\libs\Helpers', 'SqlMode'],
        ],
        'authClientCollection' => [
            'class' => \an602\modules\user\authclient\Collection::class,
            'clients' => [],
        ],
        'queue' => [
            'class' => \an602\modules\queue\driver\MySQL::class,
        ],
        'urlManager' => [
            'class' => \an602\components\UrlManager::class,
        ],
        'live' => [
            'class' => \an602\modules\live\components\Sender::class,
            'driver' => [
                'class' => \an602\modules\live\driver\Poll::class,
            ],
        ],
        'mutex' => [
            'class' => \yii\mutex\MysqlMutex::class
        ],
    ],
    'params' => [
        'installed' => false,
        'databaseInstalled' => false,
        'databaseDefaultStorageEngine' => 'InnoDB',
        'dynamicConfigFile' => '@config/dynamic.php',
        'moduleAutoloadPaths' => ['@app/modules', '@an602/modules'],
        'availableLanguages' => [
            'en-US' => 'English (US)',
            'en-GB' => 'English (UK)',
            'de' => 'Deutsch',
            'fr' => 'Français',
            'nl' => 'Nederlands',
            'pl' => 'Polski',
            'pt' => 'Português',
            'pt-BR' => 'Português do Brasil',
            'es' => 'Español',
            'ca' => 'Català',
            'it' => 'Italiano',
            'th' => 'ไทย',
            'tr' => 'Türkçe',
            'ru' => 'Русский',
            'uk' => 'українська',
            'el' => 'Ελληνικά',
            'ja' => '日本語',
            'hu' => 'Magyar',
            'nb-NO' => 'Norsk bokmål',
            'nn-NO' => 'Nynorsk',
            'zh-CN' => '中文(简体)',
            'zh-TW' => '中文(台灣)',
            'an' => 'Aragonés',
            'vi' => 'Tiếng Việt',
            'sv' => 'Svenska',
            'cs' => 'čeština',
            'da' => 'dansk',
            'uz' => 'Ўзбек',
            'fa-IR' => 'فارسی',
            'bg' => 'български',
            'sk' => 'slovenčina',
            'ro' => 'română',
            'ar' => 'العربية/عربي‎‎',
            'ko' => '한국어',
            'id' => 'Bahasa Indonesia',
            'lt' => 'lietuvių kalba',
            'ht' => 'Kreyòl ayisyen',
            'lv' => 'Latvijas',
            'sl' => 'Slovenščina',
            'hr' => 'Hrvatski',
            'am' => 'አማርኛ',
            'fi' => 'suomalainen',
            'he' => 'עברית',
            'sq' => 'Shqip',
            'cy' => 'Cymraeg',
            'sw' => 'Kiswahili',
        ],
        'ldap' => [
            // LDAP date field formats
            'dateFields' => [
                //'birthday' => 'Y.m.d'
            ],
        ],
        'formatter' => [
            // Default date format, used especially in DatePicker widgets
            // Deprecated: Use Yii::$app->formatter->dateInputFormat instead.
            'defaultDateFormat' => 'short',
            // Seconds before switch from relative time to date format
            // Set to false to always use relative time in TimeAgo Widget
            'timeAgoBefore' => 172800,
            // Use static timeago instead of timeago js
            'timeAgoStatic' => false,
            // Seconds before hide time from timeago date
            // Set to false to always display time
            'timeAgoHideTimeAfter' => 259200,
            // Optional: Callback for TimageAgo FullDateFormat
            //'timeAgoFullDateCallBack' => function($timestamp) {
            //    return 'formatted';
            //}
        ],
        'an602' => [
            // Marketplace / New Version Check
            'apiEnabled' => true,
            'apiUrl' => 'https://api.metamz.network',
        ],
        'search' => [
            'zendLucenceDataDir' => '@runtime/searchdb',
        ],
        'curl' => [
            // Check SSL certificates on cURL requests
            'validateSsl' => true,
        ],
        // Allowed languages limitation (optional)
        'allowedLanguages' => [],
        'defaultPermissions' => [],
        'richText' => [
            'class' => \an602\modules\content\widgets\richtext\ProsemirrorRichText::class,
        ],
        'twemoji' => [
            'path' => '@web-static/img/twemoji/',
            'size' => '72x72'
        ],
        'enablePjax' => true,
        'dailyCronExecutionTime' => '18:00',
    ],
    'container' => [
        'definitions' => [
            //todo: Remove after Yii 2.0.48 release
            \yii\validators\DateValidator::class => an602\components\validators\DateValidator::class,
        ]
    ]
];

return $config;
