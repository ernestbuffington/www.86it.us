<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\activity\components;

use Yii;
use an602\components\rendering\MailLayoutRenderer;

/**
 * MailRenderer for Activity models
 *
 * @since 1.2
 * @author buddha
 */
class ActivityMailRenderer extends MailLayoutRenderer
{

    /**
     * @inheritdoc
     */
    public $subPath = 'mail';

    /**
     * @inheritdoc
     */
    public $layout = '@activity/views/layouts/mail.php';

    /**
     * @inheritdoc
     */
    public $textLayout = '@activity/views/layouts/mail_plaintext.php';

}
