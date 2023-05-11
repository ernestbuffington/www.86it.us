<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2016 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\user\authclient;

/**
 * @deprecated 1.14
 */
class GitHub extends \yii\authclient\clients\GitHub
{

    /**
     * @inheritdoc
     */
    protected function normalizeUserAttributes($attributes)
    {
        if (!isset($attributes['email'])) {
            $emails = $this->api('user/emails', 'GET');

            if (is_array($emails)) {
                foreach ($emails as $email) {
                    if ($email['primary'] == 1 && $email['verified'] == 1) {
                        $attributes['email'] = $email['email'];
                        break;
                    }
                }
            }
        }

        return parent::normalizeUserAttributes($attributes);
    }

    /**
     * @inheritdoc
     */
    protected function defaultViewOptions()
    {
        return [
            'cssIcon' => 'fa fa-github',
            'buttonBackgroundColor' => '#4078C0',
        ];
    }

    /**
     * @inheritdoc
     */
    protected function defaultNormalizeUserAttributeMap()
    {
        return [
            'username' => 'login',
            'firstname' => function ($attributes) {
                if (!isset($attributes['name'])) {
                    return '';
                }
                $parts = mb_split(' ', $attributes['name'], 2);
                if (isset($parts[0])) {
                    return $parts[0];
                }
                return '';
            },
            'lastname' => function ($attributes) {
                if (!isset($attributes['name'])) {
                    return '';
                }
                $parts = mb_split(' ', $attributes['name'], 2);
                if (isset($parts[1])) {
                    return $parts[1];
                }
                return '';
            },
        ];
    }

}
