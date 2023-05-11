<?php

namespace an602\modules\space\widgets;

use an602\modules\space\models\Space;
use an602\modules\space\models\Membership;

/**
 * Shows newly created spaces as sidebar widget
 *
 * @package an602.modules_core.space.widgets
 * @since 0.11
 * @author Luke
 */
class NewSpaces extends \yii\base\Widget
{

    public $showMoreButton = false;

    /**
     * Executes the widgets
     */
    public function run()
    {
        $query = Space::find();

        /**
         * Show private spaces only if user is member
         */
        $query->leftJoin('space_membership', 'space.id=space_membership.space_id AND space_membership.user_id=:userId', [':userId' => \Yii::$app->user->id]);
        $query->andWhere([
            '!=', 'space.visibility', Space::VISIBILITY_NONE,
        ]);
        $query->orWhere([
            'space_membership.status' => Membership::STATUS_MEMBER,
        ]);
        $query->limit(10);
        $query->orderBy('created_at DESC');

        return $this->render('newSpaces', [
                    'newSpaces' => $query->all(),
                    'showMoreButton' => $this->showMoreButton
        ]);
    }

}