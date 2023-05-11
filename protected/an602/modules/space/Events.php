<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2018 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\space;

use an602\modules\space\permissions\SpaceDirectoryAccess;
use an602\modules\ui\menu\MenuLink;
use an602\modules\user\events\UserEvent;
use an602\modules\space\models\Space;
use an602\modules\space\models\Membership;
use an602\modules\space\helpers\MembershipHelper;
use Yii;
use yii\base\BaseObject;
use an602\components\Event;

/**
 * Events provides callbacks for all defined module events.
 *
 * @author luke
 */
class Events extends BaseObject
{

    /**
     * On rebuild of the search index, rebuild all space records
     *
     * @param Event $event
     */
    public static function onSearchRebuild($event)
    {
        foreach (Space::find()->each() as $space) {
            Yii::$app->search->add($space);
        }
    }

    /**
     * Callback on user soft deletion
     *
     * @param UserEvent $event
     */
    public static function onUserSoftDelete(UserEvent $event)
    {
        $user = $event->user;

        // Delete spaces which this user owns
        foreach (MembershipHelper::getOwnSpaces($user) as $ownedSpace) {
            $ownedSpace->delete();
        }

        // Cancel all space memberships
        foreach (Membership::findAll(['user_id' => $user->id]) as $membership) {
            // Avoid activities
            $membership->delete();
        }

        // Cancel all space invites by the user
        foreach (Membership::findAll(['originator_user_id' => $user->id, 'status' => Membership::STATUS_INVITED]) as $membership) {
            // Avoid activities
            $membership->delete();
        }
    }

    /**
     * Callback to validate module database records.
     *
     * @param Event $event
     */
    public static function onIntegrityCheck($event)
    {
        $integrityController = $event->sender;

        $integrityController->showTestHeadline("Space Module - Spaces (" . Space::find()->count() . " entries)");
        foreach (Space::find()->each() as $space) {
            foreach ($space->applicants as $applicant) {
                if ($applicant->user == null) {
                    if ($integrityController->showFix("Deleting applicant record id " . $applicant->id . " without existing user!")) {
                        $applicant->delete();
                    }
                }
            }
        }

        $integrityController->showTestHeadline("Space Module - Memberships (" . models\Membership::find()->count() . " entries)");
        foreach (models\Membership::find()->joinWith('space')->each() as $membership) {
            if ($membership->space == null) {
                if ($integrityController->showFix("Deleting space membership " . $membership->space_id . " without existing space!")) {
                    $membership->delete();
                }
            }
            if ($membership->user == null) {
                if ($integrityController->showFix("Deleting space membership " . $membership->user_id . " without existing user!")) {
                    $membership->delete();
                }
            }
        }
    }

    /**
     * On build of the TopMenu
     *
     * @param Event $event
     */
    public static function onTopMenuInit($event)
    {
        /** @var Module $module */
        $module = Yii::$app->getModule('space');
        if ($module->hideSpacesPage) {
            return;
        }

        if (!Yii::$app->user->isGuest &&
            !Yii::$app->user->can(SpaceDirectoryAccess::class)) {
            return;
        }

        $event->sender->addEntry(new MenuLink([
            'id' => 'spaces',
            'icon' => 'dot-circle-o',
            'label' => Yii::t('SpaceModule.base', 'Spaces'),
            'url' => ['/space/spaces'],
            'sortOrder' => 250,
            'isActive' => MenuLink::isActiveState('space', 'spaces'),
        ]));
    }

}
