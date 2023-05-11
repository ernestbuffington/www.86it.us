<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2021 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\components\export;

/**
 * ArrayColumn exports array values to [[SpreadsheetExport]] widget.
 */
class ArrayColumn extends DataColumn
{
    /**
     * @inheritdoc
     */
    public function renderDataCellContent($model, $key, $index)
    {
        if ($this->content === null) {
            $value = $this->getDataCellValue($model, $key, $index);
            if (is_array($value)) {
                return $this->grid->formatter->format(implode(', ', $value), $this->format);
            }
        }

        return parent::renderDataCellContent($model, $key, $index);
    }
}
