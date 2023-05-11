<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2019 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\ldap;

use an602\components\Event;
use an602\modules\ldap\models\LdapSettings;
use an602\modules\user\authclient\Collection;
use Yii;
use yii\base\BaseObject;
use yii\helpers\Url;

/**
 * Events provides callbacks for all defined module events.
 *
 * @author luke
 */
class Events extends BaseObject
{
    /**
     * @param $event Event
     */
    public static function onAuthenticationMenu($event)
    {
        $event->sender->addItem([
            'label' => Yii::t('LdapModule.base', 'LDAP'),
            'url' => Url::to(['/ldap/admin']),
            'sortOrder' => 200,
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'ldap' && Yii::$app->controller->id == 'admin'),
        ]);
    }

    /**
     * @param $event Event
     */
    public static function onAuthClientCollectionSet($event)
    {
        if (LdapSettings::isEnabled()) {
            /** @var Collection $collection */
            $collection = $event->sender;

            $settings = new LdapSettings();
            $settings->loadSaved();

            $configParams = (isset($event->parameters['clients']['ldap'])) ? $event->parameters['clients']['ldap'] : [];
            $collection->setClient('ldap', array_merge($settings->getLdapAuthDefinition(), $configParams));
        }
    }

}
