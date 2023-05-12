<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2015 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\installer\forms;

use Yii;

/**
 * DatabaseForm holds all required database settings.
 *
 * @since 0.5
 */
class DatabaseForm extends \yii\base\Model
{

    /**
     * @var string hostname
     */
    public $hostname;

    /**
     * @var integer port
     */
    public $port;

    /**
     * @var string username
     */
    public $username;

    /**
     * @var string password
     */
    public $password;

    /**
     * @var string database name
     */
    public $database;

    /**
     * @var string Create database if it doesn't exist
     */
    public $create;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hostname', 'username', 'database'], 'required'],
            ['password', 'safe'],
            ['port', 'integer'],
            ['create', 'in', 'range' => [0, 1]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'hostname' => Yii::t('InstallerModule.base', 'Hostname'),
            'port' => Yii::t('InstallerModule.base', 'Port'),
            'username' => Yii::t('InstallerModule.base', 'Username'),
            'password' => Yii::t('InstallerModule.base', 'Password'),
            'database' => Yii::t('InstallerModule.base', 'Name of Database'),
            'create' => Yii::t('InstallerModule.base', 'Create the database if it doesn\'t exist yet.'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return [
            'hostname' => Yii::t('InstallerModule.base', 'Hostname of your MySQLi Database Server (e.g. localhost if MySQLi is running on the same machine)'),
            'port' => Yii::t('InstallerModule.base', 'Optional: Port of your MySQL Database Server. Leave empty to use default port.'),
            'username' => Yii::t('InstallerModule.base', 'Your MySQLi username'),
            'password' => Yii::t('InstallerModule.base', 'Your MySQLi password.'),
            'database' => Yii::t('InstallerModule.base', 'The name of the database that you want to run PHP-AN602 in.'),
        ];
    }

}
