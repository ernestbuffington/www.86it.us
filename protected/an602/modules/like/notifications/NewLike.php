<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\like\notifications;

use an602\modules\content\interfaces\ContentOwner;
use Yii;
use yii\bootstrap\Html;
use an602\modules\notification\components\BaseNotification;

/**
 * Notifies a user about likes of his objects (posts, comments, tasks & co)
 *
 * @since 0.5
 */
class NewLike extends BaseNotification
{

    /**
     * @inheritdoc
     */
    public $moduleId = 'like';

    /**
     * @inheritdoc
     */
    public $viewName = 'newLike';

    /**
     * @inheritdoc
     */
    public function category()
    {
        return new LikeNotificationCategory();
    }

    /**
     * @inheritdoc
     */
    public function getGroupKey()
    {
        $model = $this->getLikedRecord();
        return get_class($model) . '-' . $model->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getMailSubject()
    {
        $model = $this->getLikedRecord();

        if(!$model instanceof ContentOwner) {
            return '';
        }

        $contentInfo = $this->getContentPlainTextInfo($model);

        if ($this->groupCount > 1) {
            return Yii::t('LikeModule.notifications', "{displayNames} likes your {contentTitle}.", [
                        'displayNames' => $this->getGroupUserDisplayNames(false),
                        'contentTitle' => $contentInfo
            ]);
        }

        return Yii::t('LikeModule.notifications', "{displayName} likes your {contentTitle}.", [
                    'displayName' => $this->originator->displayName,
                    'contentTitle' => $contentInfo
        ]);
    }

    /**
     * @inheritdoc
     */
    public function html()
    {
        $model = $this->getLikedRecord();

        if(!$model instanceof ContentOwner) {
            return '';
        }

        $contentInfo = $this->getContentInfo($model);

        if ($this->groupCount > 1) {
            return Yii::t('LikeModule.notifications', "{displayNames} likes {contentTitle}.", [
                        'displayNames' => $this->getGroupUserDisplayNames(),
                        'contentTitle' => $contentInfo
            ]);
        }

        return Yii::t('LikeModule.notifications', "{displayName} likes {contentTitle}.", [
                    'displayName' => Html::tag('strong', Html::encode($this->originator->displayName)),
                    'contentTitle' => $contentInfo
        ]);
    }

    /**
     * The liked record
     *
     * @return \an602\components\ActiveRecord
     */
    public function getLikedRecord()
    {
        return $this->source->getSource();
    }
}
