<?php


namespace web;


use an602\modules\web\Module;
use an602\modules\web\security\helpers\Security;
use tests\codeception\_support\an602DbTestCase;
use Yii;
use yii\helpers\Json;

class WebSecurityTest extends an602DbTestCase
{
    /**
     * @return Module
     */
    public function _before()
    {
        parent::_before();
        Security::setNonce(null);
        $this->setConfigFile('security.default.json');
    }

    protected function setConfigFile($configFile)
    {
        /** @var $module Module */
        $module = Yii::$app->getModule('web');
        $configFile = realpath(__DIR__.'/../data/security/'.$configFile);
        $module->security = Json::decode(file_get_contents($configFile));
    }
}
