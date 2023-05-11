<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\models\forms;

use Yii;
use yii\base\Model;

/**
 * ChooseLanguage is the model of the language select box to change language for
 * guests.
 */
class ChooseLanguage extends Model
{

    /**
     * @var string the language
     */
    public $language;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['language', 'in', 'range' => array_keys(Yii::$app->i18n->getAllowedLanguages())],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'language' => Yii::t('base', 'Language'),
        ];
    }

    /**
     * Stores language as cookie
     *
     * @since 1.2
     * @return boolean
     */
    public function save()
    {
        if ($this->validate()) {
            $cookie = new \yii\web\Cookie([
                'name' => 'language',
                'value' => $this->language,
                'expire' => time() + 86400 * 365,
            ]);
            Yii::$app->getResponse()->getCookies()->add($cookie);

            return true;
        }

        return false;
    }

    /**
     * Returns the saved language in the cookie
     *
     * @return string the stored language
     */
    public function getSavedLanguage()
    {
        if (isset(Yii::$app->request->cookies['language'])) {
            $this->language = (string) Yii::$app->request->cookies['language'];

            if (!$this->validate()) {
                // Invalid cookie
                $cookie = new \yii\web\Cookie([
                    'name' => 'language',
                    'value' => 'en-US',
                    'expire' => 1,
                ]);
                Yii::$app->getResponse()->getCookies()->add($cookie);
            } else {
                return $this->language;
            }
        }

        return null;
    }

}
