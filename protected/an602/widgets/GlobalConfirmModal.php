<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2016 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\widgets;

use Yii;

/**
 * GlobalConfirmModal used as template for an602.ui.modal.confirm actions.
 *
 * @see LayoutAddons
 * @author buddha
 * @since 1.2
 */
class GlobalConfirmModal extends \yii\base\Widget
{

    /**
     * @inheritdoc
     */
    public function run()
    {
        return \an602\widgets\Modal::widget([
            'id' => 'globalModalConfirm',
            'jsWidget' => 'ui.modal.ConfirmModal',
            'size' => 'extra-small',
            'centerText' => true,
            'backdrop' => false,
            'keyboard' => false,
            'animation' => 'pulse',
            'initialLoader' => false,
            'footer' => '<button data-modal-cancel data-modal-close class="btn btn-default">' . Yii::t('base', 'Cancel') . '</button><button data-modal-confirm data-modal-close class="btn btn-primary">' . Yii::t('base', 'Confirm') . '</button>'
        ]);
    }

}
