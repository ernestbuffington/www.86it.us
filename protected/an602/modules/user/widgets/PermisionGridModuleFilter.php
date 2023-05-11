<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2019 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\user\widgets;


use an602\libs\Html;
use an602\modules\user\assets\PermissionGridModuleFilterAsset;
use an602\widgets\JsWidget;
use Yii;

/**
 * Renders a dropdown in order to filter the permission overview by module.
 */
class PermisionGridModuleFilter extends JsWidget
{
    /**
     * @inheritdocs
     */
    public $jsWidget = 'user.PermissionGridModuleFilter';

    /**
     * @inheritdocs
     */
    public $init = true;

    /**
     * @inheritdocs
     */
    public function run()
    {
        PermissionGridModuleFilterAsset::register($this->view);
        return Html::dropDownList('', [], ['all' => Yii::t('base', 'All')], $this->getOptions());
    }

    public function getData()
    {
        return [
            'action-change' => 'change',
        ];
    }

    public function getAttributes()
    {
        return [
            'class' => 'form-control pull-right visible-md visible-lg',
            'style' => 'width:150px;margin-right:20px'
        ];
    }

}
