<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\content\activities;

use Yii;
use an602\modules\activity\components\BaseActivity;
use an602\modules\activity\interfaces\ConfigurableActivityInterface;

/**
 * Activity for created content 
 *
 * @see \an602\modules\content\components\ContentActiveRecord
 * @author luke
 */
class ContentCreated extends BaseActivity implements ConfigurableActivityInterface
{

    /**
     * @inheritdoc
     */
    public $moduleId = 'content';

    /**
     * @inheritdoc
     */
    public $viewName = 'created';

    /**
     * @inheritdoc
     */
    public function getTitle()
    {
        return Yii::t('ContentModule.activities', 'Contents');
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return Yii::t('ContentModule.activities', 'Whenever a new content (e.g. post) has been created.');
    }

}
