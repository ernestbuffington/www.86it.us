<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2018 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 *
 */

namespace an602\modules\ui\filter\widgets;


use an602\components\Widget;
use yii\helpers\Html;

/**
 * Widget for rendering stream filter blocks.
 *
 * Stream filter blocks are used to categorize filters.
 *
 * @since 1.3
 */
class FilterBlock extends Widget
{
    /**
     * @var string block title
     */
    public $title;

    /**
     * @var array of active filter definitions
     * @see FilterInput
     */
    public $filters = [];

    /**
     * @var array html options for container
     */
    public $options = [];

    /**
     * @var int sort order
     */
    public $sortOrder;

    /**
     * @var string view to render
     */
    public $view = 'filterListBlock';

    /**
     * @inheritdoc
     */
    public function run()
    {
        if (empty($this->filters)) {
            return '';
        }

        Html::addCssClass($this->options, 'filter-block');

        return $this->render($this->view, [
            'filters' => $this->filters,
            'title' => $this->title,
            'options' => $this->options,
        ]);
    }

    public function addFilter($filter)
    {
        $this->filters[] = $filter;
    }

}
