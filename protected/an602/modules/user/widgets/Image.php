<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\user\widgets;

use an602\modules\ui\widgets\BaseImage;
use Yii;
use an602\libs\Html;
use an602\modules\user\models\User;

/**
 * Image shows the user profile image
 *
 * @since 1.2
 * @author Luke
 */
class Image extends BaseImage
{
    /**
     * @var \an602\modules\user\models\User
     */
    public $user;

    /**
     * @inheritdoc
     */
    public $link = true;

    /**
     * @inheritdoc
     */
    public function run()
    {
        if ($this->user->status == User::STATUS_SOFT_DELETED) {
            $this->link = false;
        }

        Html::addCssClass($this->imageOptions, 'img-rounded');
        Html::addCssStyle($this->imageOptions, 'width: ' . $this->width . 'px; height: ' . $this->height . 'px');

        if ($this->tooltipText || $this->showTooltip) {
            $this->imageOptions['data-toggle'] = 'tooltip';
            $this->imageOptions['data-placement'] = 'top';
            $this->imageOptions['data-html'] = 'true';
            $this->imageOptions['data-original-title'] = ($this->tooltipText) ? $this->tooltipText : Html::encode($this->user->displayName);
            Html::addCssClass($this->imageOptions, 'tt');
        }

        $this->imageOptions['data-contentcontainer-id'] = $this->user->contentcontainer_id;

        $this->imageOptions['alt'] = Yii::t('base', 'Profile picture of {displayName}', ['displayName' => Html::encode($this->user->displayName)]);
        $html = Html::img($this->user->getProfileImage()->getUrl(), $this->imageOptions);

        if ($this->link) {
            $html = Html::a($html, $this->user->getUrl(), $this->linkOptions);
        }

        $html = Html::tag('span', $html, $this->htmlOptions);

        return $html;
    }

}
