<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\models;

use Yii;

/**
 * This is the model class for table "module_enabled".
 *
 * @property string $module_id
 */
class ModuleEnabled extends \yii\db\ActiveRecord
{

    const CACHE_ID_ALL_IDS = 'enabledModuleIds';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'module_enabled';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['module_id'], 'required'],
            [['module_id'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'module_id' => 'Module ID',
        ];
    }

    public function afterDelete()
    {
        Yii::$app->cache->delete(self::CACHE_ID_ALL_IDS);

        return parent::afterDelete();
    }

    public function afterSave($insert, $changedAttributes)
    {
        Yii::$app->cache->delete(self::CACHE_ID_ALL_IDS);

        return parent::afterSave($insert, $changedAttributes);
    }

    public static function getEnabledIds()
    {
        $enabledModules = Yii::$app->cache->get(self::CACHE_ID_ALL_IDS);
        if ($enabledModules === false) {
            $enabledModules = [];
            foreach (\an602\models\ModuleEnabled::find()->all() as $em) {
                $enabledModules[] = $em->module_id;
            }
            Yii::$app->cache->set(self::CACHE_ID_ALL_IDS, $enabledModules);
        }

        return $enabledModules;
    }

}
