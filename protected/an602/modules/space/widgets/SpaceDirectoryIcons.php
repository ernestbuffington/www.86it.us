<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2021 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\space\widgets;

use an602\components\Widget;
use an602\modules\space\models\Membership;
use an602\modules\space\models\Space;
use an602\modules\user\models\User;
use Yii;

/**
 * SpaceDirectoryIcons shows footer icons for spaces cards
 *
 * @since 1.9
 * @author Luke
 */
class SpaceDirectoryIcons extends Widget
{

    /**
     * @var Space
     */
    public $space;

    /**
     * @inheritdoc
     */
    public function run()
    {
        if ($this->space->getAdvancedSettings()->hideMembers) {
            return '';
        }

        $membership = $this->space->getMembership();
        $membersCountQuery = Membership::getSpaceMembersQuery($this->space)->active();
        if (Yii::$app->user->isGuest) {
            $membersCountQuery->andWhere(['!=', 'user.visibility', User::VISIBILITY_HIDDEN]);
        } else {
            $membersCountQuery->visible();
        }

        return $this->render('spaceDirectoryIcons', [
            'space' => $this->space,
            'membersCount' => Yii::$app->formatter->asShortInteger($membersCountQuery->count()),
            'canViewMembers' => $membership && $membership->isPrivileged(),
        ]);
    }

}
