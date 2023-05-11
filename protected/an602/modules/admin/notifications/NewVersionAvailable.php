<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\admin\notifications;

use Yii;
use yii\helpers\Url;
use yii\bootstrap\Html;
use an602\modules\notification\components\BaseNotification;
use an602\modules\admin\libs\an602API;

/**
 * an602UpdateNotification
 *
 * Notifies about new an602 Version
 *
 * @since 0.11
 */
class NewVersionAvailable extends BaseNotification
{

    /**
     * @inheritdoc
     */
    public $moduleId = 'admin';

    /**
     * @inheritdoc
     */
    public $requireOriginator = false;

    /**
     * @inheritdoc
     */
    public $requireSource = false;

    /**
     * @inheritdoc
     */
    public function getUrl()
    {
        return Url::to(['/admin/information/about']);
    }

    /**
     * @inheritdoc
     */
    public function category()
    {
        return new AdminNotificationCategory;
    }

    /**
     * @inheritdoc
     */
    public function getLatestan602Version()
    {
        return an602API::getLatestan602Version();
    }

    /**
     * @inheritdoc
     */
    public function html()
    {
        return Yii::t('AdminModule.notification', "There is a new an602 Version ({version}) available.", ['version' => Html::tag('strong', $this->getLatestan602Version())]);
    }

}

?>
