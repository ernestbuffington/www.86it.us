<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\admin\jobs;

use an602\modules\admin\libs\an602API;
use an602\modules\admin\Module;
use an602\modules\admin\notifications\NewVersionAvailable;
use an602\modules\queue\ActiveJob;
use an602\modules\user\models\Group;
use Yii;


/**
 * CheckForNewVersion checks for new an602 version and sends a notification to
 * the administrators
 *
 * @since 1.2
 * @author Luke
 */
class CheckForNewVersion extends ActiveJob
{

    /**
     * @inheritdoc
     */
    public function run()
    {
        /** @var Module $adminModule */
        $adminModule = Yii::$app->getModule('admin');

        if (!$adminModule->dailyCheckForNewVersion || !Yii::$app->params['an602']['apiEnabled']) {
            return;
        }

        $latestVersion = an602API::getLatestan602Version();

        if (!empty($latestVersion)) {

            $adminUserQuery = Group::getAdminGroup()->getUsers();

            $latestNotifiedVersion = $adminModule->settings->get('lastVersionNotify');
            $adminsNotified = !($latestNotifiedVersion == "" || version_compare($latestVersion, $latestNotifiedVersion, ">"));
            $newVersionAvailable = (version_compare($latestVersion, Yii::$app->version, ">"));

            $updateNotification = new NewVersionAvailable();

            // Cleanup existing notifications
            if (!$newVersionAvailable || ($newVersionAvailable && !$adminsNotified)) {
                foreach ($adminUserQuery->all() as $admin) {
                    $updateNotification->delete($admin);
                }
            }

            // Create new notification
            if ($newVersionAvailable && !$adminsNotified) {
                $updateNotification->sendBulk($adminUserQuery);
                $adminModule->settings->set('lastVersionNotify', $latestVersion);
            }
        }
    }

}
