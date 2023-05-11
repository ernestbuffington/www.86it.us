<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2019 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\marketplace\widgets;

use an602\components\Widget;
use an602\modules\marketplace\models\Licence;
use an602\modules\marketplace\Module;
use Yii;

class AboutVersion extends Widget
{

    /**
     * @inheritDoc
     */
    public function run()
    {
        /** @var Module $module */
        $module = Yii::$app->getModule('marketplace');

        $licence = $module->getLicence();

        if ($licence->type === Licence::LICENCE_TYPE_PRO) {
            if (isset(Yii::$app->params['hosting'])) {
                return $this->render('about_version_pro_cloud', ['licence' => $licence]);
            } else {
                return $this->render('about_version_pro', ['licence' => $licence]);
            }
        } else {
            return $this->render('about_version');
        }
    }

}
