<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 *
 */

namespace an602\modules\content\widgets;

use an602\libs\Html;
use Yii;
use an602\modules\content\components\ContentContainerActiveRecord;
use an602\modules\ui\form\widgets\BasePicker;
use an602\modules\content\models\ContentTag;

/**
 * This InputWidget provides a generic ContentTag Dropdown
 *
 *
 * @package an602\modules\content\widgets
 */
class ContentTagPicker extends BasePicker
{
    /**
     * @var string tagClass
     */
    public $itemClass = ContentTag::class;

    /**
     * @var string tagClass
     */
    public $limit = 50;

    public $showDefaults = false;

    /**
     * @var ContentContainerActiveRecord container can be used to create urls etc
     */
    public $contentContainer;

    public function init()
    {
        parent::init();
        if($this->showDefaults) {
            $this->defaultResults = $this->findDefaults();
        }
    }

    protected function findDefaults()
    {
        $query = call_user_func([$this->itemClass, 'findByContainer'], $this->contentContainer, true);
        return $query->limit($this->limit)->all();
    }

    public static function search($term, $contentContainer = null, $includeGlobal = false)
    {
        $instance = new static();
        $query = call_user_func([$instance->itemClass, 'find']);
        if(!empty($term)) {
            $query->andWhere(['like', 'content_tag.name', $term]);
        }
        return static::jsonResult($query->limit($instance->limit)->all());
    }

    public static function searchByContainer($term, $contentContainer, $includeGlobal = true)
    {
        if(!$contentContainer) {
            return static::search($term);
        }

        $instance = new static();
        $query = call_user_func([$instance->itemClass, 'findByContainer'], $contentContainer, $includeGlobal);

        if(!empty($term)) {
            $query->andWhere(['like','content_tag.name', $term]);
        }

        return static::jsonResult($query->limit($instance->limit)->all());
    }

    public static function jsonResult($tags)
    {
        $result = [];
        foreach($tags as $tag) {
            $result[] = [
                'id' => $tag->id,
                'text' => $tag->name
            ];
        }

        return $result;
    }

    /**
     * Used to retrieve the option text of a given $item.
     *
     * @param \yii\db\ActiveRecord $item selected item
     * @return string item option text
     */
    protected function getItemText($item)
    {
        if(!$item instanceof ContentTag) {
            return;
        }

        return $item->name;
    }

    /**
     * Used to retrieve the option image url of a given $item.
     *
     * @param \yii\db\ActiveRecord $item selected item
     * @return string|null image url or null if no selection image required.
     */
    protected function getItemImage($item)
    {
        return null;
    }
}
