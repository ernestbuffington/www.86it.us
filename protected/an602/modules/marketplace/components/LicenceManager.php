<?php


/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2020 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\marketplace\components;

use an602\modules\admin\libs\an602API;
use an602\modules\marketplace\models\Licence;
use an602\modules\marketplace\Module;
use an602\modules\space\models\Space;
use an602\modules\user\models\User;
use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\base\Event;


/**
 * Class LicenceManager
 *
 * @package an602\modules\marketplace\components
 */
class LicenceManager extends Component
{

    /**
     * @var Licence
     */
    private static $_licence = null;

    /**
     * @event Event an event that is triggered when the current licence is requested
     */
    const EVENT_GET_LICENCE = 'getLicence';


    const SETTING_KEY_PE_LICENCE_KEY = 'licenceKey';
    const SETTING_KEY_PE_LAST_FETCH = 'lastFetch';
    const SETTING_KEY_PE_LICENCED_TO = 'licencedTo';
    const SETTING_KEY_PE_MAX_USERS = 'maxUsers';

    const PE_FETCH_INTERVAL = 60 * 60 * 2;
    const PE_FETCH_TOLERANCE = 60 * 60 * 24 * 5;


    /**
     * Returns the current licence object
     *
     * @param boolean $useCache
     * @return Licence
     */
    public static function get($useCache = true)
    {
        if (static::$_licence === null || !$useCache) {
            static::$_licence = static::create();
            Event::trigger(static::class, static::EVENT_GET_LICENCE);
        }

        return static::$_licence;
    }


    /**
     * Returns the current licence object
     *
     * @return Licence
     */
    private static function create()
    {
        $settings = static::getModule()->settings;

        $licence = new Licence(['type' => Licence::LICENCE_TYPE_CE]);

        $lastFetch = (int)$settings->get(static::SETTING_KEY_PE_LAST_FETCH);
        if (!empty($settings->get(static::SETTING_KEY_PE_LICENCE_KEY))) {

            // Update
            if ($lastFetch + static::PE_FETCH_INTERVAL < time()) {
                if (!static::fetch() && $lastFetch + static::PE_FETCH_TOLERANCE < time()) {
                    $lastFetchDateTime = 'empty';
                    try {
                        $lastFetchDateTime = Yii::$app->formatter->asDatetime($lastFetch, 'full');
                    } catch (InvalidConfigException $e) {
                        Yii::error($e->getMessage(), 'marketplace');
                    }
                    Yii::error('Could not fetch PE licence since: ' . $lastFetchDateTime, 'marketplace');
                    return $licence;
                }
            }

            if (!empty($settings->get(static::SETTING_KEY_PE_LICENCED_TO)) && !empty($settings->get(static::SETTING_KEY_PE_MAX_USERS))) {
                $licence->type = Licence::LICENCE_TYPE_PRO;
                $licence->maxUsers = $settings->get(static::SETTING_KEY_PE_MAX_USERS);
                $licence->licencedTo = $settings->get(static::SETTING_KEY_PE_LICENCED_TO);
                $licence->licenceKey = $settings->get(static::SETTING_KEY_PE_LICENCE_KEY);
                return $licence;
            }
        }

        if (isset(Yii::$app->params['hosting'])) {
            // In our demo hosting, we allow pro licences without registration
            $licence->type = Licence::LICENCE_TYPE_PRO;
        }

        return $licence;

    }

    /**
     * Fetches the licence from the an602 API
     *
     * @return bool The retrieval of the license worked, whether it is valid or not.
     */
    public static function fetch()
    {
        $result = static::request('v1/pro/get');

        if (empty($result) || !is_array($result) || !isset($result['status'])) {
            // Connection failure
            return false;
        }

        if ($result['status'] === 'ok') {
            static::getModule()->settings->set(static::SETTING_KEY_PE_LICENCE_KEY, $result['licence']['licenceKey']);
            static::getModule()->settings->set(static::SETTING_KEY_PE_LICENCED_TO, $result['licence']['licencedTo']);
            static::getModule()->settings->set(static::SETTING_KEY_PE_MAX_USERS, $result['licence']['maxUsers']);
            static::getModule()->settings->set(static::SETTING_KEY_PE_LAST_FETCH, time());

            return true;
        } elseif ($result['status'] === 'not-found') {
            try {
                if (static::remove()) {
                    return true;
                }
            } catch (\Throwable $e) {
                Yii::error('Could not fetch/remove licence: ' . $e->getMessage());
            }
        }

        return false;
    }


    /**
     * Removes the licence from this installation and the an602 Marketplace
     *
     * @return boolean
     */
    public static function remove()
    {
        $licenceKey = static::getModule()->settings->get('licenceKey');
        if (!empty($licenceKey)) {
            $result = static::request('v1/pro/unregister', ['licenceKey' => $licenceKey]);
        }

        static::getModule()->settings->delete(static::SETTING_KEY_PE_LICENCE_KEY);
        static::getModule()->settings->delete(static::SETTING_KEY_PE_LICENCED_TO);
        static::getModule()->settings->delete(static::SETTING_KEY_PE_MAX_USERS);
        static::getModule()->settings->delete(static::SETTING_KEY_PE_LAST_FETCH);

        return true;
    }

    /**
     * Request an602 API backend
     *
     * @param $url
     * @param array $params
     * @return array
     */
    public static function request($url, $params = [])
    {
        return an602API::request($url, array_merge($params, static::getStats()));
    }


    /**
     * @return array some basic stats
     */
    private static function getStats()
    {
        return [
            'tua' => User::find()->andWhere(['status' => User::STATUS_ENABLED])->count(),
            'tu' => User::find()->count(),
            'ts' => Space::find()->count(),
        ];
    }

    /**
     * @return Module the marketplace module
     */
    private static function getModule()
    {
        return Yii::$app->getModule('marketplace');
    }


}
