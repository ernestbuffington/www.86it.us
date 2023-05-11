<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2020 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\admin\widgets;

use an602\modules\admin\models\PendingRegistrationSearch;
use yii\helpers\Url;
use an602\widgets\JsWidget;
use Yii;
use yii\data\ActiveDataProvider;


/**
 * PendingRegistrations shows a grid view of all open/pending UserInvites
 *
 * @since 1.8
 * @package an602\modules\admin\widgets
 */
class PendingRegistrations extends JsWidget
{
    /**
     * @inheritdoc
     */
    public $jsWidget = 'admin.PendingRegistrations';

    /**
     * @var ActiveDataProvider
     */
    public $dataProvider;

    /**
     * @var PendingRegistrationSearch
     */
    public $searchModel;

    /**
     * The types of pending registrations
     * @var array
     */
    public $types;

    /**
     * @inheritdoc
     */
    public $init = true;

    /**
     * @inheritDoc
     */
    public function run()
    {
        return $this->render('pending-registrations',
            [
                'dataProvider' => $this->dataProvider,
                'searchModel' => $this->searchModel,
                'types' => $this->types,
                'options' => $this->getOptions(),
            ]);
    }

    /**
     * @inheritDoc
     */
    public function getAttributes()
    {
        return [
            'class' => 'PendingRegistrations'
        ];
    }

    /**
     * @inheritDoc
     */
    public function getData()
    {
        return [
            'url-delete-selected' => Url::to(['pending-registrations/delete-all-selected']),
            'url-delete-all' => Url::to(['pending-registrations/delete-all']),
            'note-delete-selected' => Yii::t('AdminModule.base', 'Delete selected rows'),
            'note-delete-all' => Yii::t('AdminModule.base', 'Delete all'),
        ];
    }
}
