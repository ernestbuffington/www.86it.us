<?php

namespace an602\modules\comment\models\forms;

use an602\modules\comment\models\Comment;
use Yii;

/**
 * AdminCommentDeleteForm is shown when admin deletes someone's comment
 */
class AdminDeleteCommentForm extends yii\base\Model
{
    /**
     * @var string
     */
    public $message;

    /**
     * @var boolean
     */
    public $notify;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['message'], 'required', 'when' => function ($model) {
                return $model->notify;
            }],
            [['message'], 'string'],
            [['notify'], 'boolean']
        ];
    }

    public function attributeLabels()
    {
        return [
            'message' => Yii::t('CommentModule.base', 'Reason'),
            'notify' => Yii::t('CommentModule.base', 'Send a notification to author')
        ];
    }
}
