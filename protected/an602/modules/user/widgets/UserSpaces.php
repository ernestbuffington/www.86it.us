<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2016 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\user\widgets;

use an602\modules\space\models\Space;
use an602\modules\space\models\Membership;

/**
 * UserSpaces widget shows all users public and active spaces in sidebar.
 *
 * @since 0.5
 * @author Luke
 */
class UserSpaces extends \yii\base\Widget
{

    /**
     * @var \an602\modules\user\models\User
     */
    public $user;

    /**
     * @var int maximum spaces to display
     */
    public $maxSpaces = 30;

    /**
     * @inheritdoc
     */
    public function run()
    {
        $query = Membership::getUserSpaceQuery($this->user)
                ->andWhere(['!=', 'space.visibility', Space::VISIBILITY_NONE])
                ->andWhere(['space.status' => Space::STATUS_ENABLED]);

        $showMoreLink = ($query->count() > $this->maxSpaces);

        return $this->render('userSpaces', [
                    'user' => $this->user,
                    'spaces' => $query->limit($this->maxSpaces)->all(),
                    'showMoreLink' => $showMoreLink,
        ]);
    }

}

?>
