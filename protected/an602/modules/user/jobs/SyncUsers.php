<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\user\jobs;

use Yii;
use an602\modules\queue\ActiveJob;
use an602\modules\user\authclient\interfaces\AutoSyncUsers;

/**
 * AutoSyncUsers
 *
 * When a authclient provider implements the AutoSyncUser interface the syncUsers
 * method is called to fetch and update users.
 * 
 * @since 1.3
 * @author Luke
 */
class SyncUsers extends ActiveJob
{

    /**
     * @inheritdoc
     */
    public function run()
    {
        foreach (Yii::$app->authClientCollection->getClients() as $authClient) {
            if ($authClient instanceof AutoSyncUsers) {
                /**
                 * @var AutoSyncUsers $authClient 
                 */
                $authClient->syncUsers();
            }
        }
    }

}
