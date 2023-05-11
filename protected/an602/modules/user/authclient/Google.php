<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2016 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\user\authclient;

use Yii;

/**
 * @deprecated 1.14
 */
class Google extends \yii\authclient\clients\Google
{

    /**
     * @inheritdoc
     */
    protected function defaultViewOptions()
    {
        return [
            'popupWidth' => 860,
            'popupHeight' => 480,
            'cssIcon' => 'fa fa-google',
            'buttonBackgroundColor' => '#e0492f',
        ];
    }

    /**
     * @inheritdoc
     */
    protected function defaultNormalizeUserAttributeMap()
    {
        return [
            'username' => 'displayName',
            'firstname' => function ($attributes) {
                if (!isset($attributes['given_name'])) {
                    return '';
                }

                return $attributes['given_name'];
            },
            'lastname' => function ($attributes) {
                if (!isset($attributes['family_name'])) {
                    return '';
                }

                return $attributes['family_name'];
            },
            'title' => 'tagline',
            'email' => function ($attributes) {
                return $attributes['email'];
            },
        ];
    }

}
