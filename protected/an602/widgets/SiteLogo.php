<?php

namespace an602\widgets;

use an602\libs\LogoImage;

class SiteLogo extends \yii\base\Widget
{

    public $place = 'topMenu';

    public function run()
    {
        return $this->render('logo', ['logo' => new LogoImage(), 'place' => $this->place]);
    }

}
