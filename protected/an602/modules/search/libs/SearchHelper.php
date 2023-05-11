<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\search\libs;

use an602\modules\search\interfaces\Searchable;
use an602\modules\search\jobs\DeleteDocument;
use an602\modules\search\jobs\UpdateDocument;
use Yii;
use yii\base\BaseObject;
use yii\db\ActiveRecord;

/**
 * SearchHelper
 *
 * @since 1.2.3
 * @author Luke
 */
class SearchHelper extends BaseObject
{

    /**
     * Checks if given text matches a search query.
     *
     * @param string $query
     * @param string $text
     * @return boolean
     */
    public static function matchQuery($query, $text)
    {
        foreach (explode(" ", $query) as $keyword) {
            if (!empty($keyword) && strpos($text, $keyword) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * Queues search index update of an active record
     *
     * @param ActiveRecord|null $record
     * @return bool
     */
    public static function queueUpdate(?ActiveRecord $record)
    {
        if ($record instanceof Searchable) {
            $pk = $record->getPrimaryKey();
            if (!empty($pk) && !is_array($pk)) {
                Yii::$app->queue->push(new UpdateDocument([
                    'activeRecordClass' => get_class($record),
                    'primaryKey' => $pk
                ]));
                return true;
            }
        }
        return false;
    }

    /**
     * Queues search index delete of an active record
     *
     * @param ActiveRecord|null $record
     * @return bool
     */
    public static function queueDelete(?ActiveRecord $record)
    {
        if ($record instanceof Searchable) {
            $pk = $record->getPrimaryKey();
            if (!empty($pk) && !is_array($pk)) {
                Yii::$app->queue->push(new DeleteDocument([
                    'activeRecordClass' => get_class($record),
                    'primaryKey' => $pk
                ]));
                return true;
            }
        }
        return false;
    }


}
