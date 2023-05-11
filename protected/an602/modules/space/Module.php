<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2016 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\space;

use an602\modules\user\models\User;
use Yii;

/**
 * SpaceModule provides all space related classes & functions.
 *
 * @author Luke
 * @since 0.5
 */
class Module extends \an602\components\Module
{

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'an602\modules\space\controllers';

    /**
     * @var boolean Allow global admins (super admin) access to private content also when no member
     */
    public $globalAdminCanAccessPrivateContent = false;

    /**
     *
     * @var boolean Do not allow multiple spaces with the same name
     */
    public $useUniqueSpaceNames = true;

    /**
     * @var boolean defines if the space following is disabled or not.
     * @since 1.2
     */
    public $disableFollow = false;

    /**
     * @var boolean defines if a space members can add anyone the the space without invitation
     * @since 1.8
     */
    public $membersCanAddWithoutInvite = false;

    /**
     * @var int maximum space url length
     * @since 1.3
     */
    public $maximumSpaceUrlLength = 45;

    /**
     * @var int minimum space url length
     * @since 1.3
     */
    public $minimumSpaceUrlLength = 2;

    /**
     * @var bool hide about page in space menu (default value for advanced settings page)
     * @since 1.7
     */
    public $hideAboutPage = false;

    /**
     * @var bool Hide "Spaces" in top menu
     * @since 1.10
     */
    public $hideSpacesPage = false;

    /**
     * @var bool Hide Activity Sidebar Widget (default value for advanced settings page)
     * @since 1.13
     */
    public $hideActivities = false;

    /**
     * @var bool Hide Members (default value for advanced settings page)
     * @since 1.13
     */
    public $hideMembers = false;

    /**
     * @var bool Hide Followers (default value for advanced settings page)
     * @since 1.13
     */
    public $hideFollowers = false;

    /**
     * @inheritdoc
     */
    public function getPermissions($contentContainer = null)
    {
        if ($contentContainer instanceof models\Space) {
            return [
                new permissions\InviteUsers(),
            ];
        } elseif ($contentContainer instanceof User) {
            return [];
        }

        return [
            new permissions\SpaceDirectoryAccess(),
            new permissions\CreatePrivateSpace(),
            new permissions\CreatePublicSpace(),
        ];
    }

    public function getName()
    {
        return Yii::t('SpaceModule.base', 'Space');
    }

    /**
     * @inheritdoc
     */
    public function getNotifications()
    {
        return [
            'an602\modules\space\notifications\ApprovalRequest',
            'an602\modules\space\notifications\ApprovalRequestAccepted',
            'an602\modules\space\notifications\ApprovalRequestDeclined',
            'an602\modules\space\notifications\Invite',
            'an602\modules\space\notifications\InviteAccepted',
            'an602\modules\space\notifications\InviteDeclined'
        ];
    }

}
