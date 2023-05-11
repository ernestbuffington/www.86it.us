<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2018 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\ui\widgets;


/**
 * Class CounterSet
 *
 * @since 1.3
 * @package an602\modules\ui\widgets
 */
class CounterSet extends \an602\components\Widget
{
    /**
     * @var CounterSetItem[]
     */
    public $counters = [];


    /**
     * @var string the template to use
     */
    public $template = '@ui/widgets/views/counterSetHeader';


    /**
     * @inheritdoc
     */
    public function run()
    {
        return $this->render($this->template, ['counters' => $this->counters]);
    }
}
