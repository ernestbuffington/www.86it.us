<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\space\activities;

use an602\modules\activity\components\BaseActivity;
use an602\modules\activity\interfaces\ConfigurableActivityInterface;
use an602\modules\content\models\Content;
use Yii;

/**
 * Description of MemberAdded
 *
 * @author luke
 */
class MemberAdded extends BaseActivity implements ConfigurableActivityInterface
{
    /**
     * @inheritdoc
     */
    public $viewName = 'memberAdded';

    /**
     * @inheritdoc
     */
    public $moduleId = 'space';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->visibility = Content::VISIBILITY_PRIVATE;
        parent::init();
    }

    public function getUrl()
    {
        if($this->originator) {
            return $this->originator->getUrl();
        }

        return parent::getUrl();
    }

    /**
     * @inheritdoc
     */
    public function getTitle()
    {
        return Yii::t('SpaceModule.activities', 'Space member joined');
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return Yii::t('SpaceModule.activities', 'Whenever a new member joined one of your spaces.');
    }

}
