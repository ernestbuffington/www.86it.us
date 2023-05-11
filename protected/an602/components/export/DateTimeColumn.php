<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2018 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\components\export;

use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

/**
 * DateTimeColumn exports DateTime values to [[SpreadsheetExport]] widget.
 */
class DateTimeColumn extends DataColumn
{
    /**
     * @var array containing style information
     * @see https://phpspreadsheet.readthedocs.io/en/develop/topics/recipes/#styles
     */
    public $styles = [
        'numberFormat' => [
            'formatCode' => NumberFormat::FORMAT_DATE_DATETIME
        ]
    ];

    /**
     * @inheritdoc
     */
    public function renderDataCellContent($model, $key, $index)
    {
        $value = Date::PHPToExcel(parent::renderDataCellContent($model, $key, $index));
        return $value === false ? null : $value;
    }
}
