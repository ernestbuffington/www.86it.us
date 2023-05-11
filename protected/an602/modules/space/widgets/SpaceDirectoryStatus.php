<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2021 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\space\widgets;

use an602\components\Widget;
use an602\modules\space\models\Space;
use Yii;

/**
 * SpaceDirectoryStatus shows status like "Archived" for spaces cards
 * 
 * @since 1.10
 * @author Luke
 */
class SpaceDirectoryStatus extends Widget
{

    /**
     * @var Space
     */
    public $space;

    /**
     * @inheritdoc
     */
    public function run()
    {
        if ($this->space->isArchived()) {
            return $this->render('spaceDirectoryStatus', [
                'class' => 'label label-primary',
                'text' => Yii::t('SpaceModule.base', 'Archived'),
            ]);
        }
    }

}
