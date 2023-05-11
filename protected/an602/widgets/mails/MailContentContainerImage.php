<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2016 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\widgets\mails;

use an602\modules\space\models\Space;

/**
 * MailContentContainerImage renders the profile image of a ContentContainer.
 *
 * @author buddha
 * @since 1.2
 */
class MailContentContainerImage extends \yii\base\Widget
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
        $url = ($this->container instanceof Space) 
                ? $this->container->createUrl('/space/space', [], true)
                : $this->container->createUrl('/user/profile', [], true);
        
        return $this->render('mailContentContainerImage', [
                    'container' => $this->container,
                    'url' => $url,
        ]);
    }

}

?>