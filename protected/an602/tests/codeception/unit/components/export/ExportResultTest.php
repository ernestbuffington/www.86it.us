<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2018 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\tests\codeception\unit;

use Codeception\Test\Unit;
use an602\components\export\ExportResult;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

/**
 * Class ExportResultTest
 *
 * This class was originally developed by Paul Klimov <klimov.paul@gmail.com> and his
 * project csv-grid (https://github.com/yii2tech/csv-grid).
 */
class ExportResultTest extends Unit
{
    const TEST_FILE = 'test.csv';

    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @Override
     */
    protected function _after()
    {
        if (is_writable(self::TEST_FILE)) {
            unlink(self::TEST_FILE);
        }
    }

    /**
     * @param array $config
     * @return ExportResult export result instance
     */
    protected function createExportResult($config = [])
    {
        $exportResult = new ExportResult($config);
        $exportResult->basePath = self::TEST_FILE;
        return $exportResult;
    }

    /**
     * Test new Spreadsheet
     */
    public function testNewSpreadsheet()
    {
        $exportResult = $this->createExportResult();

        $spreadsheet = $exportResult->newSpreadsheet();
        $this->assertTrue($spreadsheet instanceof Spreadsheet);
    }

    /**
     * @depends testNewSpreadsheet
     */
    public function testResultFileName()
    {
        $exportResult = $this->createExportResult([
            'fileBaseName' => 'newname',
        ]);

        $this->assertEquals('newname.csv', $exportResult->getResultFileName());
    }
}
