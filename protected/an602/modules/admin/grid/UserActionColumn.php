<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\admin\grid;

use Yii;
use an602\libs\ActionColumn;
use an602\modules\user\models\User;

/**
 * UserActionColumn
 *
 * @author Luke
 */
class UserActionColumn extends ActionColumn
{

    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        /** @var User $model */

        $actions = [];
        if ($model->status == User::STATUS_SOFT_DELETED) {
            $actions[Yii::t('AdminModule.user', 'Permanently delete')] = ['delete'];
        } else {
            $actions[Yii::t('base', 'Edit')] = ['edit'];

            if(Yii::$app->user->isAdmin() || !$model->isSystemAdmin()) {
                $actions[] = '---';
                if ($model->status == User::STATUS_DISABLED) {
                    $actions[Yii::t('AdminModule.user', 'Enable')] = ['enable', 'linkOptions' => ['data-method' => 'post', 'data-confirm' => Yii::t('AdminModule.user', 'Are you really sure that you want to enable this user?')]];
                } elseif ($model->status == User::STATUS_ENABLED) {
                    $actions[Yii::t('AdminModule.user', 'Disable')] = ['disable', 'linkOptions' => ['data-method' => 'post', 'data-confirm' => Yii::t('AdminModule.user', 'Are you really sure that you want to disable this user?')]];
                }
                if (!$model->isCurrentUser()) {
                    $actions[Yii::t('base', 'Delete')] = ['delete'];
                }
            }


            if ($model->status == User::STATUS_ENABLED) {
                $actions[] = '---';
                if (Yii::$app->user->canImpersonate($model)) {
                    $actions[Yii::t('AdminModule.user', 'Impersonate')] = ['impersonate', 'linkOptions' => ['data-method' => 'post', 'data-confirm' => Yii::t('AdminModule.user', 'Are you really sure that you want to impersonate this user?')]];
                }
                $actions[Yii::t('AdminModule.user', 'View profile')] = ['view-profile'];
            }
        }
        $this->actions = $actions;

        return parent::renderDataCellContent($model, $key, $index);
    }

}
