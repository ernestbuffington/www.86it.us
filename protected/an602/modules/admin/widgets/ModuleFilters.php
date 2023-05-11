<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2021 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\admin\widgets;

use an602\libs\Html;
use an602\modules\ui\icon\widgets\Icon;
use an602\modules\ui\widgets\DirectoryFilters;
use Yii;

/**
 * ModuleFilters displays the filters on the modules list
 *
 * @since 1.11
 * @author Luke
 */
class ModuleFilters extends DirectoryFilters
{
    /**
     * @inheritdoc
     */
    public $pageUrl = '/admin/module/list';

    /**
     * @inheritdoc
     */
    public $paginationUsed = false;

    protected function initDefaultFilters()
    {
        $this->addFilter('keyword', [
            'title' => Yii::t('AdminModule.base', 'Search'),
            'placeholder' => Yii::t('AdminModule.base', 'Search...'),
            'type' => 'input',
            'wrapperClass' => 'col-md-7 form-search-filter-keyword',
            'afterInput' => Html::submitButton(Icon::get('search'), ['class' => 'form-button-search']),
            'sortOrder' => 100,
        ]);
    }

}
