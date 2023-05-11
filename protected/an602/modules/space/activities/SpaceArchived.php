<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\space\activities;

use Yii;
use an602\modules\activity\components\BaseActivity;
use an602\modules\activity\interfaces\ConfigurableActivityInterface;

/**
 * Description of MemberAdded
 *
 * @author luke
 */
class SpaceArchived extends BaseActivity implements ConfigurableActivityInterface
{
    /**
     * @inheritdoc
     */
    public $viewName = 'spaceArchived';

    /**
     * @inheritdoc
     */
    public $moduleId = 'space';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->visibility = \an602\modules\content\models\Content::VISIBILITY_PRIVATE;
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function getTitle()
    {
        return Yii::t('SpaceModule.activities', 'Space has been archived');
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return Yii::t('SpaceModule.activities', 'Whenever a space is archived.');
    }
}
