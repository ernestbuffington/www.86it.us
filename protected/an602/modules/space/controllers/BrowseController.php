<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2018 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\space\controllers;

use an602\components\Controller;
use an602\components\behaviors\AccessControl;
use an602\modules\content\widgets\ContainerTagPicker;
use an602\modules\space\models\Space;
use an602\modules\space\widgets\Chooser;
use Yii;
use yii\data\Pagination;

/**
 * BrowseController
 *
 * @author Luke
 * @package an602.modules_core.space.controllers
 * @since 0.5
 */
class BrowseController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'acl' => [
                'class' => AccessControl::class,
                'guestAllowedActions' => ['search-json']
            ]
        ];
    }

    /**
     * Returns a workspace list by json
     *
     * It can be filtered by by keyword.
     */
    public function actionSearchJson()
    {
        Yii::$app->response->format = 'json';

        $query = Space::find()->visible()->filterBlockedSpaces();
        $query->search(Yii::$app->request->get('keyword'));

        $countQuery = clone $query;
        $pagination = new Pagination(['totalCount' => $countQuery->count(), 'pageSizeParam' => 'limit']);

        $query->offset($pagination->offset)->limit($pagination->limit);

        return $this->asJson($this->prepareResult($query->all()));
    }

    /**
     * @return \yii\web\Response
     * @throws \Throwable
     */
    public function actionSearchLazy()
    {
        return $this->asJson(Chooser::getLazyLoadResult());
    }

    /**
     * Returns space tags list in JSON format filtered by keyword
     */
    public function actionSearchTagsJson()
    {
        $keyword = Yii::$app->request->get('keyword');
        $pickerTags = ContainerTagPicker::searchTagsByContainerClass(Space::class, $keyword);

        return $this->asJson($pickerTags);
    }

    /**
     * @param $spaces Space[] array of spaces
     * @return array
     */
    protected function prepareResult($spaces)
    {
        $target = Yii::$app->request->get('target');

        $json = [];
        $withChooserItem = ($target === 'chooser');
        foreach ($spaces as $space) {
            $json[] = Chooser::getSpaceResult($space, $withChooserItem);
        }

        return $json;
    }
}
