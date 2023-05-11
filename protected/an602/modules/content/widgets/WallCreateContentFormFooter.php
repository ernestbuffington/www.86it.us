<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2022 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\content\widgets;

use an602\components\Widget;
use an602\modules\content\components\ContentContainerActiveRecord;
use an602\modules\content\permissions\CreatePublicContent;
use an602\modules\file\handler\FileHandlerCollection;
use an602\modules\space\models\Space;
use Yii;
use yii\web\HttpException;

/**
 * WallCreateContentFormFooter is the footer options widget under create content forms on Stream/Wall.
 *
 * @author luke
 */
class WallCreateContentFormFooter extends Widget
{

    /**
     * @var string form submit route/url (required)
     */
    public $submitUrl;

    /**
     * @var string submit button text
     */
    public $submitButtonText;

    /**
     * @var ContentContainerActiveRecord this content will belong to
     */
    public $contentContainer;

    /**
     * @inheritdoc
     */
    public function init()
    {
        if ($this->submitButtonText == '') {
            $this->submitButtonText = Yii::t('ContentModule.base', 'Submit');
        }

        if (!($this->contentContainer instanceof ContentContainerActiveRecord)) {
            throw new HttpException(500, 'No Content Container given!');
        }

        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        return $this->render('@an602/modules/content/widgets/views/wallCreateContentFormFooter', [
            'contentContainer' => $this->contentContainer,
            'submitUrl' => $this->contentContainer->createUrl($this->submitUrl),
            'submitButtonText' => $this->submitButtonText,
            'canSwitchVisibility' => $this->contentContainer->visibility !== Space::VISIBILITY_NONE && $this->contentContainer->can(CreatePublicContent::class),
            'fileHandlers' => FileHandlerCollection::getByType([FileHandlerCollection::TYPE_IMPORT, FileHandlerCollection::TYPE_CREATE]),
            'pickerUrl' => $this->contentContainer instanceof Space ? $this->contentContainer->createUrl('/space/membership/search') : null,
            'scheduleUrl' => $this->contentContainer->createUrl('/content/content/schedule-options')
        ]);
    }
}
