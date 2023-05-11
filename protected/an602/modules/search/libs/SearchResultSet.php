<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2016 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\search\libs;

use an602\components\ActiveRecord;
use Yii;

/**
 * SearchResultSet
 *
 * @author luke
 */
class SearchResultSet
{

    /**
     * @var SearchResult[] the search rsults
     */
    public $results = [];

    /**
     * @var int number of total results
     */
    public $total = 0;

    /**
     * @var int the current page
     */
    public $page = 1;

    /**
     * @var int page size
     */
    public $pageSize;


    /**
     * Returns active record instances of the search results
     *
     * @return ActiveRecord[]
     */
    public function getResultInstances()
    {
        $instances = [];

        foreach ($this->results as $result) {
            /** @var $modelClass ActiveRecord */
            $modelClass = $result->model;
            if (!class_exists($modelClass)) {
                Yii::info('Could not find class ' . $modelClass, 'search');
                continue;
            }
            try {
                $instance = $modelClass::findOne(['id' => $result->pk]);
            } catch (\Exception $ex) {
                Yii::info('Could not load result model class ' . $result->model . ". Error: " . $ex->getMessage(), 'search');
                continue;
            }
            if ($instance !== null) {
                $instances[] = $instance;
            } else {
                Yii::info('Could not load search result ' . $result->model . " - " . $result->pk, 'search');
            }
        }

        return $instances;
    }

}
