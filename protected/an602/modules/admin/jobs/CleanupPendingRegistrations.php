<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2020 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\admin\jobs;

use an602\modules\admin\Module;
use an602\modules\queue\ActiveJob;
use an602\modules\user\models\Invite;
use Yii;

/**
 * CleanupLog deletes older log records from log table
 *
 * @since 1.8
 */
class CleanupPendingRegistrations extends ActiveJob
{
    /**
     * @inheritdoc
     * @throws \yii\base\InvalidConfigException
     */
    public function run()
    {
        /** @var Module $module */
        $module = Yii::$app->getModule('admin');

        Invite::deleteAll(['<', 'created_at', Yii::$app->formatter->asDatetime(time() - $module->cleanupPendingRegistrationInterval, 'php:Y-m-d H:i:s')]);
    }


}
