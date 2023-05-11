<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2022 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\admin\models\forms;

use an602\modules\marketplace\Module;
use Yii;
use yii\base\Model;

/**
 * ModuleFilterSettingsForm is used to modify module filter settings
 *
 * @package an602.modules_core.admin.forms
 * @since 1.11
 */
class GeneralModuleSettingsForm extends Model
{
    /**
     * @var Module
     */
    private $marketplaceModule;

    /**
     * @var bool
     */
    public $includeBetaUpdates;

    public function init()
    {
        parent::init();

        $this->marketplaceModule = Yii::$app->getModule('marketplace');
        $this->includeBetaUpdates = (bool)$this->marketplaceModule->settings->get('includeBetaUpdates', false);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['includeBetaUpdates'], 'boolean'],
        ];
    }

    /**
     * @inheritDoc
     */
    public function attributeLabels()
    {
        return [
            'includeBetaUpdates' => Yii::t('AdminModule.modules', 'Allow module versions in beta status')
        ];
    }

    /**
     * @return bool
     */
    public function save()
    {
        if (!$this->validate()) {
            return false;
        }

        if ($this->marketplaceModule) {
            $this->marketplaceModule->settings->set('includeBetaUpdates', $this->includeBetaUpdates);
        }

        return true;
    }
}
