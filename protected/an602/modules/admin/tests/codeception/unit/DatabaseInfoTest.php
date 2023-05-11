<?php

namespace an602\modules\admin\tests\codeception\unit;

use Codeception\Test\Unit;
use an602\modules\admin\components\DatabaseInfo;

class DatabaseInfoTest extends Unit
{
    public function testGetDatabaseNameByMysqlDsn()
    {
        $data = [
            'an602_demo1' => 'mysql:host=127.0.0.1;dbname=an602_demo1',
            'an602_demo3' => 'mysql:host=127.0.0.1;port:3310;dbname=an602_demo3',
            'testdb1' => 'mysql:host=localhost;dbname=testdb1',
            'testdb2' => 'mysql:host=localhost;port=3307;dbname=testdb2',
            'testdb3' => 'mysql:unix_socket=/tmp/mysql.sock;dbname=testdb3',
            'testdb4' => 'mysql:unix_socket=/tmp/mysql.sock;dbname=testdb4;charset=utf8',
        ];

        foreach ($data as $name => $dsn) {
            $dbInfo = new DatabaseInfo($dsn);
            $this->assertEquals($name, $dbInfo->getDatabaseName());
        }
    }
}
