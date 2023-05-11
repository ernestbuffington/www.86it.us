<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2021 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace tests\codeception\unit\modules\file;

use an602\modules\file\models\File;
use an602\modules\file\models\FileHistory;
use an602\modules\post\models\Post;
use tests\codeception\_support\an602DbTestCase;

class FileHistoryTest extends an602DbTestCase
{

    public function testRecordWithEnabledHistory()
    {
        $file = $this->prepareFile();
        $file->getPolymorphicRelation()->fileManagerEnableHistory = true;

        $file->setStoredFileContent('V1');
        $file->setStoredFileContent('V2');
        $file->setStoredFileContent('V3');

        // Test History creation
        $this->assertEquals(2, count($file->historyFiles));
        $this->assertSame('V3', file_get_contents($file->store->get()));
    }

    public function testRollback()
    {
        $file = $this->prepareFile();
        $file->getPolymorphicRelation()->fileManagerEnableHistory = true;

        $file->setStoredFileContent('V1');
        $file->setStoredFileContent('V2');
        $file->setStoredFileContent('V3');

        /** @var FileHistory $previousVersion */
        $previousVersion = $file->getHistoryFiles()->one();

        // Test Rollback
        $file->setStoredFile($previousVersion->getFileStorePath());
        $this->assertSame('V2', file_get_contents($file->store->get()));
    }


    public function testRecordWithDisabledHistory()
    {
        $file = $this->prepareFile();

        $file->setStoredFileContent('V1');
        $file->setStoredFileContent('V2');
        $file->setStoredFileContent('V3');

        $this->assertEquals(0, count($file->historyFiles));
        $this->assertSame('V3', file_get_contents($file->store->get()));
    }


    /**
     * @return File
     */
    private function prepareFile()
    {
        $post = Post::findOne(['id' => 1]);

        $file = new File();
        $file->file_name = "Test";
        $file->save();

        $post->fileManager->attach($file);

        return $file;
    }

}
