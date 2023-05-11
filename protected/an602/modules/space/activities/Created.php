<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2015 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\space\activities;

use an602\modules\activity\components\BaseActivity;
use an602\modules\content\models\Content;

/**
 * Description of SpaceCreated
 *
 * @author luke
 */
class Created extends BaseActivity
{

    /**
     * @inheritdoc
     */
    public $moduleId = 'space';

    /**
     * @inheritdoc
     */
    public $clickable = false;

    /**
     * @inheritdoc
     */
    public $viewName = 'created';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->visibility = Content::VISIBILITY_PUBLIC;
        parent::init();
    }

}
