<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2020 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\marketplace\jobs;

use an602\modules\marketplace\components\LicenceManager;
use an602\modules\queue\ActiveJob;

class PeActiveCheckJob extends ActiveJob
{
    /**
     * @inheritdoc
     */
    public function run()
    {
        LicenceManager::get();
    }
}
