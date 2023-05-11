<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\live\components;

/**
 * LiveEvent implements a message which can be send via live communication
 *
 * @since 1.2
 * @author Luke
 */
abstract class LiveEvent extends \yii\base\BaseObject
{

    /**
     * @see \an602\modules\content\components\ContentContainerActiveRecord
     * @var int
     */
    public $contentContainerId;

    /**
     * @see \an602\modules\content\models\Content::VISIBILITY_*
     * @var int
     */
    public $visibility;

    /**
     * Returns the data of this event as array
     * 
     * @return array the live event data
     */
    public function getData()
    {
        $data = get_object_vars($this);
        unset($data['visibility']);
        unset($data['contentContainerId']);

        return [
            'type' => str_replace('\\', '.', $this->className()),
            'contentContainerId' => $this->contentContainerId,
            'visibility' => $this->visibility,
            'data' => $data
        ];
    }

}
