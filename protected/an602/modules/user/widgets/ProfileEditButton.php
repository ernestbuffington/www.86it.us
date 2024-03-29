<?php

namespace an602\modules\user\widgets;

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
use Yii;


/**
 * ProfileEditButtonWidget
 *
 * @author luke
 * @package an602.modules_core.user.widgets
 * @since 0.11
 */
class ProfileEditButton extends \yii\base\Widget
{

    public $user;

    public function run()
    {
        if (Yii::$app->user->isGuest || !$this->user->isCurrentUser()) {
            return;
        }

        return $this->render('profileEditButton', ['user' => $this->user]);
    }

}
