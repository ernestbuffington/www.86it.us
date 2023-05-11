<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\user\grid;

use an602\modules\user\widgets\Image as UserImage;

/**
 * ImageColumn
 *
 * @since 1.3
 * @author Luke
 */
class ImageColumn extends BaseColumn
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
        return UserImage::widget(['user' => $this->getUser($model), 'width' => 34]);
    }

}
