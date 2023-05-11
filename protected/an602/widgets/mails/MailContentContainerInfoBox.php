<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2016 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\widgets\mails;

use an602\libs\Helpers;

/**
 * MailContentContainerInfoBox for rendering a simple info box with contentcotnainer image,name and description.
 *
 * @author buddha
 * @since 1.2
 */
class MailContentContainerInfoBox extends \yii\base\Widget
{
    /**
     * @var \an602\modules\content\components\ContentContainerActiveRecord
     */
    public $container;

    /**
     * @inheritdoc
     */
    public function run()
    {
        if ($this->container instanceof \an602\modules\space\models\Space) {
            return $this->render('mailContentContainerInfoBox', [
                        'container' => $this->container,
                        'url' => $this->container->createUrl('/space/space', [], true),
                        'description' => Helpers::trimText($this->container->description, 60)

            ]);
        } elseif ($this->container instanceof \an602\modules\user\models\User) {
            return $this->render('mailContentContainerInfoBox', [
                        'container' => $this->container,
                        'url' => $this->container->createUrl('/user/profile', [], true),
                        'description' => Helpers::trimText($this->container->displayNameSub, 60)

            ]);
        }
    }
}
