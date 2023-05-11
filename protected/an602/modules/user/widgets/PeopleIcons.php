<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2021 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\user\widgets;

use an602\components\Widget;
use an602\modules\user\models\User;

/**
 * PeopleIcons shows footer icons for people cards
 * 
 * @since 1.9
 * @author Luke
 */
class PeopleIcons extends Widget
{

    /**
     * @var User
     */
    public $user;

    /**
     * @inheritdoc
     */
    public function run()
    {
        return $this->render('peopleIcons', [
            'user' => $this->user
        ]);
    }

}
