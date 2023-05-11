<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2015 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\widgets;



/**
 * @inheritdoc
 */
class LinkPager extends \yii\widgets\LinkPager
{

    /**
     * @inheritdoc
     */
    public $maxButtonCount = 5;

    /**
     * @inheritdoc
     */
    public $nextPageLabel = '<i class="fa fa-step-forward"></i>';

    /**
     * @inheritdoc
     */
    public $prevPageLabel = '<i class="fa fa-step-backward"></i>';

    /**
     * @inheritdoc
     */
    public $firstPageLabel = '<i class="fa fa-fast-backward"></i>';

    /**
     * @inheritdoc
     */
    public $lastPageLabel = '<i class="fa fa-fast-forward"></i>';

}
