<?php

namespace an602\modules\dashboard\widgets;

use an602\modules\post\widgets\Form;
use Yii;
use an602\modules\stream\widgets\StreamViewer;
use an602\components\Widget;
use an602\modules\content\components\ContentContainerActiveRecord;

class DashboardContent extends Widget
{
    /**
     * @var ContentContainerActiveRecord
     */
    public $contentContainer;

    /**
     * @var boolean
     */
    public $showProfilePostForm = false;

    public function run()
    {
        if ($this->showProfilePostForm) {
            echo Form::widget(['contentContainer' => $this->contentContainer]);
        }

        if ($this->contentContainer === null) {
            $messageStreamEmpty = Yii::t('DashboardModule.base', '<b>No public contents to display found!</b>');
        } else {
            $messageStreamEmpty = Yii::t('DashboardModule.base', '<b>Your dashboard is empty!</b><br>Post something on your profile or join some spaces!');
        }

        echo StreamViewer::widget([
            'streamAction' => '//dashboard/dashboard/stream',
            'showFilters' => (boolean) Yii::$app->getModule('dashboard')->settings->get('showProfilePostForm'),
            'messageStreamEmpty' => $messageStreamEmpty
        ]);
    }
}
