<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2018 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\ui\form\widgets;

use an602\assets\DatePickerRussianLanguageAsset;
use Yii;
use yii\helpers\FormatConverter;
use yii\helpers\Json;
use yii\jui\DatePicker as BaseDatePicker;
use an602\libs\Html;
use yii\jui\DatePickerLanguageAsset;
use yii\jui\JuiAsset;

/**
 * DatePicker form field widget
 *
 * @since 1.3.0
 * @inheritdoc
 * @package an602\modules\ui\form\widgets
 */
class DatePicker extends BaseDatePicker
{
    const LANGUAGEMAPPING = [
        'nb-NO' => 'nb',
        'nn-NO' => 'nn',
        'fa-IR' => 'fa',
        'an' => null,
        'uz' => null,
        'ht' => null,
        'am' => null,
    ];

    public $pickerLanguage;

    /**
     * @inheritdoc
     */
    public function init()
    {
        if ($this->dateFormat === null) {
            $this->dateFormat = Yii::$app->formatter->dateInputFormat;
        }

        Html::addCssClass($this->options, 'form-control');

        parent::init();

        $this->pickerLanguage = $this->language ? $this->language : Yii::$app->language;
        $this->pickerLanguage = (array_key_exists($this->pickerLanguage, static::LANGUAGEMAPPING))
            ? static::LANGUAGEMAPPING[$this->pickerLanguage]
            : $this->pickerLanguage;

        if(!$this->pickerLanguage) {
            $this->pickerLanguage = 'en-US';
        }

        $this->pickerLanguage = str_replace('_', '-', $this->pickerLanguage);
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        /**
         * an602 PATCH: Language Mapping + Prevent loading language files for all english based languages, since DatePickerLanguageAsset tries
         * to load a fallback language e.g. for `en-GB` -> 'en'.
         */

        $this->options['autocomplete'] = 'off';

        $language = $this->language ? $this->language : Yii::$app->language;

        echo $this->renderWidget() . "\n";

        $containerID = $this->inline ? $this->containerOptions['id'] : $this->options['id'];

        if (strncmp($this->dateFormat, 'php:', 4) === 0) {
            $this->clientOptions['dateFormat'] = FormatConverter::convertDatePhpToJui(substr($this->dateFormat, 4));
        } else {
            $this->clientOptions['dateFormat'] = FormatConverter::convertDateIcuToJui($this->dateFormat, 'date', $language);
        }

        if ($this->pickerLanguage !== 'en-US' && $this->pickerLanguage !== 'en') {
            $this->registerLanguageAsset();

            $options = Json::htmlEncode($this->clientOptions);
            $this->pickerLanguage = Html::encode($this->pickerLanguage);
            $this->getView()->registerJs("jQuery('#{$containerID}').datepicker($.extend({}, $.datepicker.regional['{$this->pickerLanguage}'], $options));");
        } else {
            $this->registerClientOptions('datepicker', $containerID);
        }

        $this->registerClientEvents('datepicker', $containerID);
        JuiAsset::register($this->getView());
    }

    private function registerLanguageAsset()
    {

        if($this->pickerLanguage === 'ru') {
            DatePickerRussianLanguageAsset::register($this->getView());
            return;
        }

        $assetBundle = DatePickerLanguageAsset::register($this->getView());
        if(substr($this->pickerLanguage, 0 , 2) === 'en') {
            $assetBundle->autoGenerate = false;
            $assetBundle->js[] = "ui/i18n/datepicker-{$this->pickerLanguage}.js";
        } else {
            $assetBundle->language = $this->pickerLanguage;
        }
    }
}
