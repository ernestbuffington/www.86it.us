<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\activity\widgets;

use an602\modules\activity\components\ActivityWebRenderer;
use an602\modules\activity\components\BaseActivity;
use an602\modules\activity\models\Activity as ActivityModel;
use an602\modules\content\widgets\stream\StreamEntryWidget;
use Yii;
use yii\base\Exception;

/**
 * ActivityWidget shows an activity.
 *
 * @author Lucas Bartholemy <lucas@bartholemy.com>
 * @package an602.modules_core.activity
 * @since 0.5
 */
class Activity extends StreamEntryWidget
{

    /**
     * @var ActivityModel is the current activity object.
     */
    public $model;

    /**
     * @inheritDoc
     */
    public $rootElement = 'li';

    /**
     * @inheritDoc
     */
    public $jsWidget = 'activity.ActivityStreamEntry';

    /**
     * @return string rendered wall entry body without the layoutRoot wrapper
     * @throws Exception
     */
    protected function renderBody()
    {
        $cacheKey = 'activity_wall_out_' . Yii::$app->language . '_' . $this->id;

        $activity = $this->model->getActivityBaseClass();

        $output = '';

        if ($activity instanceof BaseActivity) {
            $renderer = new ActivityWebRenderer();
            $output = $renderer->render($activity);
            Yii::$app->cache->set($cacheKey, $output);
        }

        return $output;
    }

    /**
     * @inheritDoc
     */
    public function getAttributes()
    {
        return [
            'class' => 'activity-entry'
        ];
    }
}
