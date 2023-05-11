<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2018 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 *
 */

namespace an602\modules\stream\models\filters;


use yii\db\Expression;
use yii\db\Query;

class TopicStreamFilter extends StreamQueryFilter
{
    const CATEGORY = 'topics';

    /**
     * Array of active topic filters.
     *
     * @var array
     */
    public $topics = [];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['topics'], 'safe']
        ];
    }

    public function apply()
    {
        if(empty($this->topics)) {
            return;
        }

        $subQuery = (new Query)->select(['count(*)'])
            ->from('content_tag_relation')
            ->where(['and', 'content_tag_relation.content_id = content.id', ['in', 'content_tag_relation.tag_id', $this->topics]]);

        $this->query->andWhere( ['=', new Expression('('.count($this->topics).')'), $subQuery]);
    }
}
