<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2021 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\content\widgets;

use an602\modules\admin\widgets\ModuleCard as AdminModuleCard;
use an602\modules\content\components\ContentContainerActiveRecord;

/**
 * ModuleCard shows a card with module data of Content Container
 * 
 * @since 1.11
 * @author Luke
 */
class ModuleCard extends AdminModuleCard
{

    /**
     * @var ContentContainerActiveRecord
     */
    public $contentContainer;

    /**
     * @inheritdoc
     */
    public function run()
    {
        $card = $this->render($this->view, [
            'module' => $this->module,
            'contentContainer' => $this->contentContainer,
        ]);

        return str_replace('{card}', $card, $this->template);
    }

}
