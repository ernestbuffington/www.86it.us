<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\activity;

use Yii;
use an602\modules\activity\interfaces\ConfigurableActivityInterface;

/**
 * Activity BaseModule
 *
 * @author Lucas Bartholemy <lucas@bartholemy.com>
 * @since 0.5
 */
class Module extends \an602\components\Module
{

    /**
     * @inheritdocs
     */
    public $resourcesPath = 'resources';

    /**
     * @var int day to send weekly summaries on daily cron run (0 = Sunday, 6 = Saturday)
     */
    public $weeklySummaryDay = 0;

    /**
     * @var boolean enable mail summary feature
     * @since 1.4
     */
    public $enableMailSummaries = true;


    /**
     * Returns all configurable Activities
     *
     * @return ConfigurableActivityInterface[] a list of configurable activities
     * @since 1.2
     */
    public static function getConfigurableActivities()
    {
        $activities = [];
        foreach (Yii::$app->getModules(false) as $moduleId => $module) {
            try {
                $module = Yii::$app->getModule($moduleId);
            } catch (\Exception $ex) {
                Yii::error('Could not load module to determine activites! Module: ' . $moduleId . ' Error: ' . $ex->getMessage(), 'activity');
                continue;
            }

            if ($module instanceof \an602\components\Module) {
                foreach ($module->getActivityClasses() as $class) {
                    $activity = new $class;
                    if ($activity instanceof ConfigurableActivityInterface) {
                        $activities[] = $activity;
                    }
                }
            }
        }

        return $activities;
    }

}
