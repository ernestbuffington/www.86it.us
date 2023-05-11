<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2018 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 *
 */

namespace an602\modules\content\widgets;

use an602\modules\content\helpers\ContentContainerHelper;
use an602\modules\content\components\ContentContainerActiveRecord;
use an602\modules\content\models\ContentType;
use an602\modules\ui\form\widgets\MultiSelect;
use Yii;

class ContentTypePicker extends MultiSelect
{
    /**
     * @var ContentContainerActiveRecord|null
     */
    public $contentContainer;

    /**
     * @var ContentType[] available types by contentContainer
     */
    public $types = [];

    /**
     * @var string icon used for content types without own icon definition
     */
    public $defaultIcon = 'fa-filter';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->placeholderMore = Yii::t('ContentModule.base', 'Select type...');

        $this->contentContainer = $this->contentContainer ? $this->contentContainer : ContentContainerHelper::getCurrent();

        parent::init();
        $this->items = ContentType::getContentTypeSelection($this->contentContainer);
        $this->types = ContentType::getContentTypes($this->contentContainer);
    }

    /**
     * @inheritdoc
     */
    protected function getItemImage($item)
    {
        foreach ($this->types as $type) {
            $itemKey = $this->getItemKey($item);

            if ($type->typeClass === $itemKey) {
                $icon = $type->getIcon();
                return empty($icon) ? $this->defaultIcon : $icon;
            }
        }
    }

    /**
     * @inheritdoc
     */
    protected function getItemText($item)
    {
        return ucfirst(parent::getItemText($item));
    }

}
