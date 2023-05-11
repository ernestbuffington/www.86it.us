<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\admin\grid;

use Yii;
use yii\bootstrap\Html;
use an602\modules\space\models\Space;
use an602\libs\Helpers;
/**
 * TitleColumn
 *
 * @since 1.3
 * @author Luke
 */
class SpaceTitleColumn extends SpaceBaseColumn
{

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if ($this->attribute === null) {
            $this->attribute = 'name';
        }

        if ($this->label === null) {
            $this->label = Yii::t('SpaceModule.base', 'Name');
        }
    }

    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        $space = $this->getSpace($model);

        $badge = '';
        if ($space->status == Space::STATUS_ARCHIVED) {
            $badge = '&nbsp;<span class="badge">'.Yii::t('SpaceModule.base', 'Archived').'</span>';
        }
        
        return '<div>' . Html::encode($space->name) . $badge . '<br> ' .
                '<small>' . Html::encode(Helpers::trimText($space->description, 100)) . '</small></div>';
    }

}
