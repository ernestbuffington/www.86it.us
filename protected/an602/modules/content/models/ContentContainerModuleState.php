<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\content\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "contentcontainer_module".
 *
 * @property integer $contentcontainer_id
 * @property string $module_id
 * @property integer $module_state
 *
 * @property ContentContainer $contentContainer
 */
class ContentContainerModuleState extends ActiveRecord
{
    /** @var int */
    const STATE_DISABLED = 0;

    /** @var int */
    const STATE_ENABLED = 1;

    /** @var int */
    const STATE_FORCE_ENABLED = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'contentcontainer_module';
    }

    /**
     * @param false $labels
     * @return array|int[]|string[]
     */
    public static function getStates($labels = false)
    {
        $states = [
            self::STATE_DISABLED => Yii::t('AdminModule.modules', 'Deactivated'),
            self::STATE_ENABLED => Yii::t('AdminModule.modules', 'Activated'),
            self::STATE_FORCE_ENABLED => Yii::t('AdminModule.modules', 'Always activated')
        ];

        return $labels ? $states : array_keys($states);
    }

    /**
     * @return ActiveQuery
     */
    public function getContentContainer()
    {
        return $this
            ->hasOne(ContentContainer::class, ['id' => 'contentcontainer_id']);
    }
}
