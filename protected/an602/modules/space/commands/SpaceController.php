<?php

/**
 * an602
 * Copyright © 2014 The an602 Project
 *
 * The texts of the GNU Affero General Public License with an additional
 * permission and of our proprietary license can be found at and
 * in the LICENSE file you have received along with this program.
 *
 * According to our dual licensing model, this program can be used either
 * under the terms of the GNU Affero General Public License, version 3,
 * or under a proprietary license.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 */

namespace an602\modules\space\commands;

use Yii;
use an602\modules\user\models\User;
use an602\modules\space\models\Space;
use yii\helpers\Console;

/**
 * Console tools for manage spaces
 *
 * @package an602.modules_core.space.console
 * @since 0.5
 */
class SpaceController extends \yii\console\Controller
{

    public function actionAssignAllMembers($spaceId)
    {
        $space = Space::findOne(['id' => $spaceId]);
        if ($space == null) {
            print "Error: Space not found! Check id!\n\n";
            return;
        }

        $countMembers = 0;
        $countAssigns = 0;

        $this->stdout("\nAdding Members:\n\n");

        foreach (User::find()->active()->all() as $user) {
            if ($space->isMember($user->id)) {
                $countMembers++;
            } else {
                $this->stdout("\t" . $user->displayName . " added. \n", Console::FG_YELLOW);

                #Yii::app()->user->setId($user->id);

                Yii::$app->user->switchIdentity($user);
                $space->addMember($user->id);
                $countAssigns++;
            }
        }

        $this->stdout("\nAdded " . $countAssigns . " new members to space " . $space->name . "\n", Console::FG_GREEN);
    }

}
