<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2020 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\marketplace\models;

use an602\modules\marketplace\components\LicenceManager;
use Yii;
use yii\base\Model;

class Licence extends Model
{
    /**
     * Licence types
     */
    const LICENCE_TYPE_CE = 'community';
    const LICENCE_TYPE_PRO = 'pro';

    /**
     * @var string the licence type
     */
    public $type;

    /**
     * @var string the licence key
     */
    public $licenceKey;

    /**
     * @var string name of the licensee
     */
    public $licencedTo;

    /**
     * @var int the number of maximum users
     */
    public $maxUsers;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->type = static::LICENCE_TYPE_CE;
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['licenceKey', 'safe'],
            ['licenceKey', 'trim'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'licenceKey' => Yii::t('MarketplaceModule.base', 'Licence key'),
        ];
    }


    /**
     * Registers the licence
     *
     * @return bool
     */
    public function register()
    {
        $result = LicenceManager::request('v1/pro/register', ['licenceKey' => $this->licenceKey]);

        if (empty($result) || !is_array($result) || !isset($result['status'])) {
            $this->addError('licenceKey', Yii::t('MarketplaceModule.base', 'Could not connect to licence server!'));
            return false;
        }

        if ($result['status'] === 'ok') {
            return true;
        }

        LicenceManager::remove();
        $this->addError('licenceKey', Yii::t('MarketplaceModule.base', 'Could not update licence. Error: ') . $result['message']);
        return false;
    }

}
