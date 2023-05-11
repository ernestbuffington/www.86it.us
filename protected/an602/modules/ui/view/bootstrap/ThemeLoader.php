<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2018 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\ui\view\bootstrap;

use an602\components\console\Application as ConsoleApplication;
use an602\libs\BaseSettingsManager;
use an602\modules\installer\libs\EnvironmentChecker;
use an602\modules\ui\view\components\Theme;
use an602\modules\ui\view\helpers\ThemeHelper;
use Yii;
use yii\base\BootstrapInterface;

/**
 * ThemeLoader is used during the application bootstrap process
 * to load the actual theme specifed in the SettingsManager.
 *
 * @since 1.3
 * @package an602\modules\ui\view\bootstrap
 */
class ThemeLoader implements BootstrapInterface
{

    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        // Skip dynamic theme loading during the installation
        if (Yii::getAlias('@web', false) === false) {
            return;
        }

        if (BaseSettingsManager::isDatabaseInstalled()) {
            $themePath = $app->settings->get('theme');
            if (!empty($themePath) && is_dir($themePath)) {
                $theme = ThemeHelper::getThemeByPath($themePath);

                if ($theme !== null) {
                    $app->view->theme = $theme;
                    $app->mailer->view->theme = $theme;
                }
            }
        } else {
            EnvironmentChecker::preInstallChecks();
        }

        if ($app->view->theme instanceof Theme) {
            if (!Yii::$app->request->isConsoleRequest && !(Yii::$app instanceof ConsoleApplication)) {
                // Register the theme (e.g. add core js/css header)
                $app->view->theme->register();
            }
        }

    }
}
