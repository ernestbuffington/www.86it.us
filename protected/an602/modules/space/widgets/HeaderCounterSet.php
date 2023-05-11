<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2018 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\space\widgets;

use an602\modules\content\models\Content;
use an602\modules\post\models\Post;
use an602\modules\space\models\Membership;
use an602\modules\space\models\Space;
use an602\modules\space\Module;
use an602\modules\ui\widgets\CounterSetItem;
use an602\modules\ui\widgets\CounterSet;
use Yii;
use yii\helpers\Url;


/**
 * Class HeaderCounterSet
 * @package an602\modules\space\widgets
 */
class HeaderCounterSet extends CounterSet
{
    /**
     * @var Space
     */
    public $space;


    /**
     * @inheritdoc
     */
    public function init()
    {

        $postQuery = Content::find()
            ->where(['object_model' => Post::class, 'contentcontainer_id' => $this->space->contentContainerRecord->id]);
        $this->counters[] = new CounterSetItem([
            'label' => Yii::t('SpaceModule.base', 'Posts'),
            'value' => $postQuery->count()
        ]);

        if (!$this->space->getAdvancedSettings()->hideMembers) {
            $this->counters[] = new CounterSetItem([
                'label' => Yii::t('SpaceModule.base', 'Members'),
                'value' => Membership::getSpaceMembersQuery($this->space)->active()->visible()->count(),
                'url' => Yii::$app->user->isGuest ? null : '#',
                'linkOptions' => Yii::$app->user->isGuest ? [] : [
                    'data-action-click' => 'ui.modal.load',
                    'data-action-url' => Url::to(['/space/membership/members-list', 'container' => $this->space])
                ]
            ]);
        }

        /** @var Module $module */
        $module = Yii::$app->getModule('space');
        if (!$module->disableFollow && !$this->space->getAdvancedSettings()->hideFollowers) {
            $this->counters[] = new CounterSetItem([
                'label' => Yii::t('SpaceModule.base', 'Followers'),
                'value' => $this->space->getFollowersQuery()->count(),
                'url' => Yii::$app->user->isGuest ? null : '#',
                'linkOptions' => Yii::$app->user->isGuest ? [] : [
                    'data-action-click' => 'ui.modal.load',
                    'data-action-url' => Url::to(['/space/space/follower-list', 'container' => $this->space])
                ]
            ]);
        }

        parent::init();
    }
}
