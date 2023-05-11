<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\components;

use an602\modules\content\components\ContentContainerController;
use an602\modules\space\models\Space;
use an602\modules\user\models\User;
use Throwable;
use Yii;
use an602\libs\BaseSettingsManager;
use an602\modules\content\components\ContentContainerActiveRecord;
use an602\modules\content\components\ContentContainerSettingsManager;

/**
 * SettingsManager application component
 *
 * @since 1.1
 * @author Luke
 */
class SettingsManager extends BaseSettingsManager
{
    /**
     * @var ContentContainerSettingsManager[] already loaded content container settings managers
     */
    protected array $contentContainers = [];

    /**
     * Returns content container
     *
     * @param ContentContainerActiveRecord $container
     * @return ContentContainerSettingsManager
     */
    public function contentContainer(ContentContainerActiveRecord $container): ContentContainerSettingsManager
    {
        if ($contentContainers = $this->contentContainers[$container->contentcontainer_id] ?? null) {
            return $contentContainers;
        }

        return $this->contentContainers[$container->contentcontainer_id] = new ContentContainerSettingsManager([
            'moduleId' => $this->moduleId,
            'contentContainer' => $container,
        ]);
    }


    /**
     * Clears runtime cached content container settings
     *
     * @param ContentContainerActiveRecord|null $container if null all content containers will be flushed
     *
     * @noinspection PhpUnused
     */
    public function flushContentContainer(ContentContainerActiveRecord $container = null)
    {
        if ($container === null) {
            $containers = $this->contentContainers;
            $this->contentContainers = [];
        } else {
            // need to create an instance, if it does not already exist, in order to then flush the underlying cache
            $containers = [$this->contentContainer($container)] ?? null;
            unset($this->contentContainers[$container->contentcontainer_id]);
        }

        array_walk($containers, static fn(ContentContainerSettingsManager $container) => $container->invalidateCache());
    }

    /**
     * Returns ContentContainerSettingsManager for the given $user or current logged-in user
     *
     * @param User|null $user
     *
     * @return ContentContainerSettingsManager|null
     * @throws Throwable
     */
    public function user(?User $user = null): ?ContentContainerSettingsManager
    {
        if ($user === null) {
            $user = Yii::$app->user->getIdentity();
            if (!$user instanceof User) {
                return null;
            }
        }

        return $this->contentContainer($user);
    }

    /**
     * Returns ContentContainerSettingsManager for the given $space or current controller space
     *
     * @param Space|null $space
     *
     * @return ContentContainerSettingsManager
     */
    public function space(?Space $space = null): ?ContentContainerSettingsManager
    {
        if ($space !== null) {
            return $this->contentContainer($space);
        }

        /** @noinspection PhpPossiblePolymorphicInvocationInspection */
        if (
            ($controller = Yii::$app->controller) instanceof ContentContainerController
            && ($space = $controller->contentContainer) instanceof Space
        ) {
            return $this->contentContainer($space);
        }

        return null;
    }

    /**
     * Indicates this setting is fixed in configuration file and cannot be
     * changed at runtime.
     *
     * @param string|int $name
     *
     * @return boolean
     */
    public function isFixed(string $name): bool
    {
        return isset(Yii::$app->params['fixed-settings'][$this->moduleId][$name]);
    }

    /**
     * @inheritdoc
     */
    public function get(string $name, $default = null)
    {
        if ($this->isFixed($name)) {
            return Yii::$app->params['fixed-settings'][$this->moduleId][$name];
        }

        return parent::get($name, $default);
    }
}
