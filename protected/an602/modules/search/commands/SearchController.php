<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2015 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\search\commands;

use Yii;
use an602\modules\search\jobs\RebuildIndex;

/**
 * Search Tools
 *
 * @package an602.modules_core.search.console
 * @since 0.12
 */
class SearchController extends \yii\console\Controller
{

    /**
     * Optimizes the search index
     */
    public function actionOptimize()
    {
        print "Optimizing search index: ";
        Yii::$app->search->optimize();
        print "OK!\n\n";
    }

    /**
     * Rebuilds the search index
     */
    public function actionRebuild()
    {
        print "Rebuild search index: ";
        Yii::$app->search->rebuild();
        print "OK!\n\n";
    }

    /**
     * Queue search index rebuild
     */
    public function actionQueueRebuild()
    {
        $job = new RebuildIndex();
        if (\an602\modules\queue\helpers\QueueHelper::isQueued($job)) {
           print "Rebuild process is already queued or running!\n";
           return;
        }
        
        Yii::$app->queue->push($job);
    }

    /**
     * Search the index
     *
     * @param string $searchString
     * @return type
     */
    public function actionFind($keyword)
    {
        $pageSize = 10;
        $model = "";
        $page = 1;

        print "Searching for: " . $keyword . " \n";

        $results = Yii::$app->search->find($keyword, [
            'pageSize' => $pageSize,
            'page' => $page,
            'model' => ($model != "") ? explode(",", $model) : null
        ]);

        print_r($results);
    }

}
