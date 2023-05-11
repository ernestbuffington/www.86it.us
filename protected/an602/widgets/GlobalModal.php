<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2016 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\widgets;

/**
 * GlobalModal is the standard modal which can be used in every layout.
 * This widget is automatically added to the page via the LayoutAddons.
 *
 * @see LayoutAddons
 * @author Luke
 * @since 1.1
 */
class GlobalModal extends Modal
{
    /**
     * @var string this id need to js scripts
     */
    public $id = 'globalModal';

    /**
     * @inheritdoc
     * It's false because it's often used for serious work, for example html forms,
     * accidental closing of which can lead to loss of user data.
     */
    public $backdrop = false;
}
