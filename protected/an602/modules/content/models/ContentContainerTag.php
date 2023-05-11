<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2021 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\content\models;

use an602\components\ActiveRecord;
use an602\modules\content\components\ContentContainerActiveRecord;
use Yii;
use yii\db\ActiveQuery;

/**
 * Tags of content containers User|Space
 *
 * @property integer $id
 * @property string $name
 * @property string $contentcontainer_class
 *
 * @package an602\modules\content\models
 * @since 1.9
 */
class ContentContainerTag extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'contentcontainer_tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'contentcontainer_class'], 'required'],
            [['name'], 'string', 'max' => '100'],
            [['contentcontainer_class'], 'string', 'max' => '60'],
            [['name'], 'validateUniqueName'],
        ];
    }

    /**
     * Validate unique tag name
     *
     * @param string $attribute
     */
    public function validateUniqueName($attribute)
    {
        $query = static::find()
            ->where(['name' => $this->$attribute])
            ->andWhere(['contentcontainer_class' => $this->contentcontainer_class]);

        if (!$this->isNewRecord) {
            $query->andWhere(['<>', 'id', $this->id]);
        }

        if ($query->count() > 0) {
            $this->addError('name', Yii::t('ContentModule.base', 'The given name is already in use.'));
        }
    }

    /**
     * Returns Tags related to the Content Container.
     *
     * @param ContentContainerActiveRecord $contentContainer
     * @return ActiveQuery
     */
    public static function findByContainer($contentContainer)
    {
        return static::find()
            ->leftJoin('contentcontainer_tag_relation', 'contentcontainer_tag.id = contentcontainer_tag_relation.tag_id')
            ->where(['contentcontainer_tag_relation.contentcontainer_id' => $contentContainer->contentcontainer_id]);
    }
}
