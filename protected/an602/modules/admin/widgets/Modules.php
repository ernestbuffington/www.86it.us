<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2021 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\admin\widgets;

use an602\components\Widget;
use an602\modules\marketplace\Module;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Modules displays the modules list
 *
 * @since 1.11
 * @author Luke
 */
class Modules extends Widget
{
    /**
     * @var array
     */
    public $groups;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->initDefaultGroups();

        parent::init();

        ArrayHelper::multisort($this->groups, 'sortOrder');
    }

    private function initDefaultGroups()
    {
        /* @var Module $marketplaceModule */
        $marketplaceModule = Yii::$app->getModule('marketplace');
        if ($marketplaceModule->isFilteredBySingleTag('not_installed')) {
            return;
        }

        $installedModules = Yii::$app->moduleManager->getModules();

        ArrayHelper::multisort($installedModules, 'isActivated', SORT_DESC);

        $this->addGroup('installed', [
            'title' => Yii::t('AdminModule.modules', 'Installed'),
            'modules' => Yii::$app->moduleManager->filterModules($installedModules),
            /* 'count' => count($installedModules), Fixed by Ernest Allen Buffington 05/07/2023 */
            'count' => is_countable($installedModules) ? count($installedModules) : 0,

            'noModulesMessage' => Yii::t('AdminModule.base', 'No modules installed yet. Install some to enhance the functionality!'),
            'sortOrder' => 100,
        ]);
    }

    public function addGroup(string $groupType, array $group)
    {
        $this->groups[$groupType] = $group;
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $modules = '';

        $alwaysVisibleGroup = 'availableUpdates';
        $displaySingleGroup = false;
        $emptyGroupCount = 0;
        
	 if (is_array($this->groups) || is_object($this->groups))
     {
		foreach ($this->groups as $groupType => $group) {
            if ($groupType !== $alwaysVisibleGroup && empty($group['modules'])) {
                $displaySingleGroup = true;
                $emptyGroupCount++;
            }
        }
	 }
	 
        $singleGroupPrinted = false;

	 if (is_array($this->groups) || is_object($this->groups))
     {
        foreach ($this->groups as $groupType => $group) {
            if ($singleGroupPrinted) {
                continue;
            }
            if (empty($group['count']) || ($emptyGroupCount === 1 && empty($group['modules']))) {
                continue;
            }
            if ($displaySingleGroup && $groupType !== $alwaysVisibleGroup) {
                $singleGroupPrinted = true;
                if (empty($group['modules'])) {
                    $group['title'] = false;
                }
            }
            $group['type'] = $groupType;
            $renderedGroup = $this->render('moduleGroup', $group);

            if (isset($group['groupTemplate'])) {
                /* $renderedGroup = str_replace('{group}', $renderedGroup, $group['groupTemplate']); Fixed by Ernest Allen Buffington 05/07/2023 11:40 AM */
                $renderedGroup = str_replace('{group}', $renderedGroup, (string) $group['groupTemplate']);

            }

            $modules .= $renderedGroup;
        }

        return $modules;
    }
  }
}
