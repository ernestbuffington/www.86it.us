<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2016 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\content;

use an602\modules\content\components\ContentContainerActiveRecord;
use an602\modules\space\models\Space;
use an602\modules\user\models\User;
use Yii;

/**
 * Content Module
 *
 * @author Luke
 */
class Module extends \an602\components\Module
{

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'an602\modules\content\controllers';

    /**
     * @since 1.1
     * @var boolean global admin can see all content
     */
    public $adminCanViewAllContent = false;

    /**
     * @since 1.1
     * @var boolean global admin can edit/delete all content
     */
    public $adminCanEditAllContent = true;

    /**
     * @since 1.1
     * @var string Custom e-mail subject for hourly update mails - default: Latest news
     */
    public $emailSubjectHourlyUpdate = null;

    /**
     * @since 1.1
     * @var string Custom e-mail subject for daily update mails - default: Your daily summary
     */
    public $emailSubjectDailyUpdate = null;

    /**
     * @since 1.2
     * @var integer Maximum allowed file uploads for posts/comments
     */
    public $maxAttachedFiles = 50;

    /**
     * @since 1.3
     * @var integer Maximum allowed number of oembeds in richtexts
     */
    public $maxOembeds = 5;

    /**
     * @var int
     * @since 1.6
     */
    public $maxPinnedSpaceContent = 10;

    /**
     * @var int
     * @since 1.6
     */
    public $maxPinnedProfileContent = 2;

    /**
     * If true richtext extensions (oembed, emojis, mentionings) of legacy richtext (< v1.3) are supported.
     *
     * Note: In case the `richtextCompatMode` module db setting is also set, both settings need to be activated. New
     * installations since an602 1.8 deactivate the compat mode by default by module db setting.
     *
     * @var bool
     * @since 1.8
     */
    public $richtextCompatMode = true;

    /**
     * @var int Interval in minutes to run a publishing of the scheduled contents
     * @since 1.14
     */
    public $publishScheduledInterval = 10;

    /**
     * @param ContentContainerActiveRecord $container
     * @since 1.6
     * @return int
     */
    public function getMaxPinnedContent(ContentContainerActiveRecord $container)
    {
        if($container instanceof User) {
            return $this->maxPinnedProfileContent;
        }

        if($container instanceof Space) {
            return $this->maxPinnedSpaceContent;
        }

        return 0;
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return Yii::t('ContentModule.base', 'Content');
    }

    /**
     * @inheritdoc
     */
    public function getPermissions($contentContainer = null)
    {
        if ($contentContainer !== null) {
            return [
                // Note: we do not return CreatePrivateContent Permission since its not writable at the moment
                new permissions\ManageContent(),
                new permissions\CreatePublicContent()
            ];
        }

        return [];
    }

    /**
     * @inheritdoc
     */
    public function getNotifications()
    {
        return [
            'an602\modules\content\notifications\ContentCreated'
        ];
    }

}
