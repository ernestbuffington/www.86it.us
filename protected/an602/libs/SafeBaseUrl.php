<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2022 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\libs;

use Yii;
use yii\helpers\BaseUrl;

/**
 * SafeBaseUrl Helper to use host from general setting "Base URL"
 *
 * @since 1.13
 * @author Luke
 */
class SafeBaseUrl extends BaseUrl
{
    /**
     * @inheritdoc
     */
    protected static function getUrlManager()
    {
        $urlManager = clone parent::getUrlManager();
        $urlManager->setHostInfo(static::getHostInfoFromSetting());
        return $urlManager;
    }

    /**
     * Get host info from general setting "Base URL"
     *
     * @return string|null
     */
    public static function getHostInfoFromSetting(): ?string
    {
        $baseUrl = Yii::$app->settings->get('baseUrl');

        if (empty($baseUrl)) {
            return null;
        }

        $data = parse_url($baseUrl);

        return $data['scheme'] . '://' . $data['host'] . (isset($data['port']) ? ':' . $data['port'] : '');
    }
}