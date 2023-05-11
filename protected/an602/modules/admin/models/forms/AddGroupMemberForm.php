<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\admin\models\forms;

use Yii;
use yii\base\Model;
use yii\web\HttpException;
use an602\modules\user\models\User;
use an602\modules\user\models\Group;

/**
 * Description of UserGroupForm
 *
 * @author buddha
 */
class AddGroupMemberForm extends Model
{

    /**
     * GroupId selection array of the form.
     * @var array
     */
    public $userGuids;

    /**
     * User model object
     * @var integer
     */
    public $groupId;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userGuids', 'groupId'], 'required']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'userGuids' => 'Add Members'
        ];
    }

    /**
     * Aligns the given group selection with the db
     * @return bool
     * @throws HttpException
     */
    public function save()
    {
        $group = $this->getGroup();

        if (!$group) {
            throw new HttpException(404, Yii::t('AdminModule.user', 'Group not found!'));
        }

        if($group->is_admin_group && !Yii::$app->user->isAdmin()) {
            throw new HttpException(403);
        }

        foreach ($this->userGuids as $userGuid) {
            $user = User::findIdentityByAccessToken($userGuid);
            if ($user) {
               $group->addUser($user);
            }
        }

        return true;
    }

    public function getGroup()
    {
        return Group::findOne(['id' => $this->groupId]);
    }
}
