<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 *
 */

namespace an602\modules\topic\controllers;


use an602\modules\content\components\ContentContainerController;
use an602\modules\content\models\Content;
use an602\modules\topic\models\forms\ContentTopicsForm;
use an602\modules\topic\widgets\TopicPicker;
use Yii;
use yii\web\HttpException;

class TopicController extends ContentContainerController
{
    /**
     * @inheritdoc
     */
    public $requireContainer = false;

    /**
     * @inheritdoc
     */
    public function getAccessRules()
    {
        return [
            ['json']
        ];
    }

    public function actionSearch($keyword)
    {
        return $this->contentContainer
            ? TopicPicker::searchByContainer($keyword, $this->contentContainer)
            : TopicPicker::search($keyword);
    }
}
