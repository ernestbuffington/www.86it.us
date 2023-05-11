<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2018 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 *
 */

namespace an602\modules\topic\models\forms;


use an602\modules\topic\models\Topic;
use yii\base\Model;

class ContentTopicsForm extends Model
{
    public $content;

    public $topics = [];

    public function init()
    {
        $this->topics = Topic::findByContent($this->content);
    }

    public function rules()
    {
        return [
            ['topics', 'safe']
        ];
    }

    public function getContentContainer()
    {
        return $this->content->container;
    }

    public function save()
    {
        if ($this->validate()) {
            Topic::attach($this->content, $this->topics);
            return true;
        }

        return false;
    }
}
