<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2016 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\post\models;

use an602\modules\content\widgets\richtext\RichText;
use an602\modules\content\components\ContentActiveRecord;
use an602\modules\post\permissions\CreatePost;
use an602\modules\post\widgets\WallEntry;
use an602\modules\search\interfaces\Searchable;
use an602\modules\user\models\User;
use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "post".
 *
 * @property integer $id
 * @property string $message
 * @property string $url
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 */
class Post extends ContentActiveRecord implements Searchable
{
    /**
     * @inheritdoc
     */
    public $wallEntryClass = WallEntry::class;

    /**
     * @inheritdoc
     */
    public $moduleId = 'post';

    /**
     * @inheritdoc
     */
    public $canMove = CreatePost::class;

    /**
     * Scenarios
     */
    const SCENARIO_AJAX_VALIDATION = 'ajaxValidation';

    /**
     * @inheritdoc
     */
    protected $createPermission = CreatePost::class;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['message'], 'required', 'except' => self::SCENARIO_AJAX_VALIDATION],
            [['message'], 'string'],
            [['url'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        // Check if Post Contains an Url
        if (preg_match('/http(.*?)(\s|$)/i', $this->message)) {
            // Set Filter Flag
            $this->url = 1;
        }

        return parent::beforeSave($insert);
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        RichText::postProcess($this->message, $this, 'message');
    }

    /**
     * @inheritdoc
     */
    public function getContentName()
    {
        return Yii::t('PostModule.base', 'post');
    }

    /**
     * @inheritdoc
     */
    public function getLabels($result = [], $includeContentName = true)
    {
        return parent::getLabels($result, false);
    }

    /**
     * @inheritdoc
     */
    public function getIcon()
    {
        return 'fa-comment';
    }

    /**
     * @inheritdoc
     */
    public function getContentDescription()
    {
        return $this->message;
    }

    /**
     * @inheritdoc
     */
    public function getSearchAttributes()
    {
        $attributes = [
            'message' => $this->message,
            'url' => $this->url,
            'user' => $this->getPostAuthorName()
        ];

        $this->trigger(self::EVENT_SEARCH_ADD, new \an602\modules\search\events\SearchAddEvent($attributes));

        return $attributes;
    }

    /**
     * @return string
     */
    private function getPostAuthorName()
    {
        $user = User::findOne(['id' => $this->created_by]);

        if ($user !== null && $user->isActive()) {
            return $user->getDisplayName();
        }

        return '';
    }

    /**
     * @inheritDoc
     */
    public function getUrl()
    {
        return Url::to(['/post/post/view', 'id' => $this->id, 'contentContainer' => $this->content->container]);
    }

}
