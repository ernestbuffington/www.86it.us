<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2021 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\admin\models\forms;

use Yii;
use yii\base\Model;

/**
 * OEmbed settings form
 *
 * @package an602.modules_core.admin.forms
 * @since 1.11
 */
class OEmbedSettingsForm extends Model
{

    /**
     * @var bool
     */
    public $requestConfirmation;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->requestConfirmation = (bool) Yii::$app->settings->get('oembed.requestConfirmation', true);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['requestConfirmation', 'boolean'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'requestConfirmation' => Yii::t('AdminModule.settings', 'Embedded content requires the user\'s consent to be loaded'),
        ];
    }

    public function save(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        Yii::$app->settings->set('oembed.requestConfirmation', $this->requestConfirmation);

        return true;
    }

}
