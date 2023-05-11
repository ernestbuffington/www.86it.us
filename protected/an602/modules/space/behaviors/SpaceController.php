<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\space\behaviors;

use an602\modules\content\components\ContentContainerController;
use an602\modules\user\helpers\AuthHelper;
use Yii;
use yii\base\Behavior;
use yii\helpers\Json;
use yii\web\HttpException;
use an602\libs\Html;
use an602\modules\space\widgets\Image;
use an602\modules\space\models\Space;
use an602\components\Controller;

/**
 * SpaceController Behavior
 *
 * In Space scopes, this behavior will automatically attached to a contentcontainer controller.
 *
 * @see Space::controllerBehavior
 * @see ContentContainerController
 * @property ContentContainerController $owner the controller
 */
class SpaceController extends Behavior
{

    /**
     * @var \an602\modules\space\models\Space
     */
    public $space;

    /**
     * @inheritdoc
     */
    public function attach($owner)
    {
        parent::attach($owner);

        if (!$this->owner->contentContainer instanceof Space) {
            throw new \yii\base\InvalidValueException('Invalid contentcontainer type of controller.');
        }

        $this->space = $this->owner->contentContainer;
    }

    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            Controller::EVENT_BEFORE_ACTION => 'beforeAction'
        ];
    }

    /**
     * @param $action
     * @throws HttpException
     */
    public function beforeAction($action)
    {
        $this->updateLastVisit();

        if (AuthHelper::isGuestAccessEnabled() && Yii::$app->user->isGuest && $this->space->visibility != Space::VISIBILITY_ALL) {
            throw new HttpException(401, Yii::t('SpaceModule.base', 'You need to login to view contents of this space!'));
        }

        if ($this->getMembership() === null && $this->space->visibility == Space::VISIBILITY_NONE && !Yii::$app->user->isAdmin()) {
            throw new HttpException(404, Yii::t('SpaceModule.base', 'Space is invisible!'));
        }

        if(empty($this->owner->subLayout)) {
            $this->owner->subLayout = "@an602/modules/space/views/space/_layout";
        }

        $this->owner->prependPageTitle($this->space->name);

        if (Yii::$app->request->isPjax || !Yii::$app->request->isAjax) {
            $options = [
                'guid' => $this->owner->contentContainer->guid,
                'name' => Html::encode($this->owner->contentContainer->name),
                'archived' => $this->space->isArchived(),
                'image' => Image::widget([
                    'space' => $this->owner->contentContainer,
                    'width' => 32,
                    'htmlOptions' => [
                        'class' => 'current-space-image',
                    ],
                ]),
            ];

            $this->owner->view->registerJs('an602.modules.space.setSpace(' . Json::encode($options) . ', ' .
                    Json::encode(Yii::$app->request->isPjax) . ')');
        }
    }

    protected function updateLastVisit()
    {
        $membership = $this->getMembership();
        if ($membership != null) {
            $membership->updateLastVisit();
        }
    }

    protected function getMembership()
    {
        // ToDo: Cache
        return $this->space->getMembership(Yii::$app->user->id);
    }

    public function getSpace()
    {
        return $this->space;
    }

}
