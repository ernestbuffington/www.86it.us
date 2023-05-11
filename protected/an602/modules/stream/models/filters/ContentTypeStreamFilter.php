<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2018 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 *
 */

namespace an602\modules\stream\models\filters;

class ContentTypeStreamFilter extends StreamQueryFilter
{
    const CATEGORY_INCLUDES = 'includes';
    const CATEGORY_EXCLUDES = 'excludes';

    public $includes;

    public $excludes;

    public function init() {
        $this->includes = $this->streamQuery->includes;
        $this->excludes = $this->streamQuery->excludes;
        parent::init();

        // Sync the query includes with our filter includes
        $this->streamQuery->includes = $this->includes;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['includes', 'excludes'], 'safe']
        ];
    }

    public function apply()
    {
        if(!empty($this->includes)) {
            if (is_string($this->includes)) {
                $this->includes = [$this->includes];
            }

            if (count($this->includes) === 1) {
                $this->query->andWhere(["content.object_model" => $this->includes[0]]);
            } elseif (!empty($this->includes)) {
                $this->query->andWhere(['IN', 'content.object_model', $this->includes]);
            }
        }

        if(!empty($this->excludes)) {
            if (is_string($this->excludes)) {
                $this->excludes = [$this->excludes];
            }

            if (count($this->excludes) === 1) {
                $this->query->andWhere(['!=', "content.object_model", $this->excludes[0]]);
            } elseif (!empty($this->excludes)) {
                $this->query->andWhere(['NOT IN', 'content.object_model', $this->excludes]);
            }
        }
    }
}
