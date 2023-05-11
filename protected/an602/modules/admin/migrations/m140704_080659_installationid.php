<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2015 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.an602.org/licences
 */

use an602\components\Migration;

class m140704_080659_installationid extends Migration
{
    public function up()
    {
        if (!$this->isInitialInstallation()) {
            $this->insert('setting', [
                'name' => 'installationId',
                'value' => md5(uniqid("", true)),
                'module_id' => 'admin'
            ]);
        }
    }

    public function down()
    {
        echo "m140704_080659_installationid does not support migration down.\n";

        return false;
    }
}
