<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\like\activities;

use Yii;
use an602\modules\activity\components\BaseActivity;
use an602\modules\activity\interfaces\ConfigurableActivityInterface;

/**
 * Like Activity
 *
 * @author luke
 */
class Liked extends BaseActivity implements ConfigurableActivityInterface
{

    /**
     * @inheritdoc
     */
    public $moduleId = 'like';

    /**
     * @inheritdoc
     */
    public $viewName = 'liked';

    /**
     * @inheritdoc
     */
    public function getViewParams($params = [])
    {
        $like = $this->source;
        $likeSource = $like->getSource();
        $params['preview'] = $this->getContentInfo($likeSource);
        return parent::getViewParams($params);
    }

    /**
     * @inheritdoc
     */
    public function getTitle()
    {
        return Yii::t('LikeModule.activities', 'Likes');
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return Yii::t('LikeModule.activities', 'Whenever someone likes something (e.g. a post or comment).');
    }

}
