<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\admin\grid;

use an602\modules\space\widgets\Image as SpaceImage;
use an602\modules\space\models\Space;

/**
 * SpaceColumn
 *
 * @since 1.3
 * @author Luke
 */
class SpaceImageColumn extends SpaceBaseColumn
{

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->options['style'] = 'width:38px';
    }

    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        return SpaceImage::widget(['space' => $this->getSpace($model), 'width' => 34, 'link' => true]);
    }

}
