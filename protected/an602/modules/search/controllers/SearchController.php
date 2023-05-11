<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2018 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\search\controllers;

use an602\components\Controller;
use an602\modules\space\models\Space;
use an602\modules\user\models\User;
use an602\modules\search\models\forms\SearchForm;
use an602\modules\search\engine\Search;
use Yii;
use yii\data\Pagination;

/**
 * Search Controller provides search functions inside the application.
 *
 * @author Luke
 * @since 0.12
 */
class SearchController extends Controller
{
    /**
     * View context used for the search view
     * @see View::$viewContext
     */
    const VIEW_CONTEXT = 'search';

    /**
     * @var string the current search keyword
     */
    public static $keyword = null;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->appendPageTitle(\Yii::t('SearchModule.base', 'Search'));
        $this->view->setViewContext(static::VIEW_CONTEXT);
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function getAccessRules()
    {
        return [
            ['login']
        ];
    }

    public function actionIndex()
    {
        $model = new SearchForm();
        $model->load(Yii::$app->request->get());

        $limitSpaces = [];
        if (!empty($model->limitSpaceGuids)) {
            foreach ($model->limitSpaceGuids as $guid) {
                $space = Space::findOne(['guid' => trim($guid)]);
                if ($space !== null) {
                    $limitSpaces[] = $space;
                }
            }
        }

        $options = [
            'page' => $model->page,
            'sort' => (empty($model->keyword)) ? 'title' : null,
            'pageSize' => $model->pageSize,
            'limitSpaces' => $limitSpaces
        ];

        if ($model->scope == SearchForm::SCOPE_CONTENT) {
            $options['type'] = Search::DOCUMENT_TYPE_CONTENT;
        } elseif ($model->scope == SearchForm::SCOPE_SPACE) {
            $options['model'] = Space::class;
        } elseif ($model->scope == SearchForm::SCOPE_USER) {
            $options['model'] = User::class;
        } else {
            $model->scope = SearchForm::SCOPE_ALL;
        }

        $searchResultSet = Yii::$app->search->find($model->keyword, $options);

        // Store static for use in widgets (e.g. fileList)
        self::$keyword = $model->keyword;

        $pagination = new Pagination;
        $pagination->totalCount = $searchResultSet->total;
        $pagination->pageSize = $searchResultSet->pageSize;

        return $this->render('index', [
                    'model' => $model,
                    'results' => $searchResultSet->getResultInstances(),
                    'pagination' => $pagination,
                    'totals' => $model->getTotals($model->keyword, $options),
                    'limitSpaces' => $limitSpaces
        ]);
    }

}
