<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2021 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\space\controllers;

use an602\components\access\ControllerAccess;
use an602\components\Controller;
use an602\modules\space\components\SpaceDirectoryQuery;
use an602\modules\space\permissions\SpaceDirectoryAccess;
use an602\modules\space\widgets\SpaceDirectoryCard;
use Yii;
use yii\helpers\Url;

/**
 * SpacesController displays users directory
 *
 * @since 1.9
 */
class SpacesController extends Controller
{

    /**
     * @inheritdoc
     */
    public $subLayout = '@space/views/spaces/_layout';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->setActionTitles([
            'index' => Yii::t('SpaceModule.base', 'Spaces'),
        ]);

        parent::init();
    }

    /**
     * Action to display spaces page
     */
    public function actionIndex()
    {
        $spaceDirectoryQuery = new SpaceDirectoryQuery();

        $urlParams = Yii::$app->request->getQueryParams();
        unset($urlParams['page']);
        array_unshift($urlParams, '/space/spaces/load-more');
        $this->getView()->registerJsConfig('cards', [
            'loadMoreUrl' => Url::to($urlParams),
        ]);

        return $this->render('index', [
            'spaces' => $spaceDirectoryQuery,
        ]);
    }

    /**
     * Action to load cards for next page by AJAX
     */
    public function actionLoadMore()
    {
        $spaceQuery = new SpaceDirectoryQuery();

        $spaceCards = '';
        foreach ($spaceQuery->all() as $space) {
            $spaceCards .= SpaceDirectoryCard::widget(['space' => $space]);
        }

        return $spaceCards;
    }

}
