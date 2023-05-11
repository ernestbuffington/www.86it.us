<?php

namespace an602\modules\user\widgets;

use an602\modules\user\models\User;
use an602\components\Widget;

/**
 * UserWall shows a user as wall entry, e.g. in the search
 */

class UserWall extends Widget
{

    /**
     * @var User $user
     */
    public $user;

    public function run()
    {
        return $this->render('userWall', ['user' => $this->user]);
    }

}
