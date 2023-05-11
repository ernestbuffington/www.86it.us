<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2015 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\user\components;

use Yii;
use yii\web\DbSession;
use yii\web\ErrorHandler;
use yii\db\Query;
use yii\db\Expression;

/**
 * @inheritdoc
 */
class Session extends DbSession
{

    /**
     * @inheritdoc
     */
    public $sessionTable = 'user_http_session';

    /**
     * Returns all current logged in users.
     *
     * @return ActiveQueryUser
     */
    public static function getOnlineUsers()
    {
        $query = \an602\modules\user\models\User::find();
        $query->leftJoin('user_http_session', 'user_http_session.user_id=user.id');
        $query->andWhere(['IS NOT', 'user_http_session.user_id', new Expression('NULL')]);
        $query->andWhere(['>', 'user_http_session.expire', time()]);
        return $query;
    }

    /**
     * @inheritDoc
     */
    public function getCookieParams()
    {
        $params = parent::getCookieParams();
        if (Yii::$app->request->autoEnsureSecureConnection &&
            Yii::$app->request->isSecureConnection) {
            $params['secure'] = true;
        }
        return $params;
    }

    /**
     * @inheritdoc
     */
    public function writeSession($id, $data)
    {
        // exception must be caught in session write handler
        // http://us.php.net/manual/en/function.session-set-save-handler.php
        try {
            $userId = new Expression('NULL');
            if (!Yii::$app->user->getIsGuest()) {
                $userId = Yii::$app->user->id;
            }

            $expire = time() + $this->getTimeout();
            $query = new Query;
            $exists = $query->select(['id'])
                ->from($this->sessionTable)
                ->where(['id' => $id])
                ->createCommand($this->db)
                ->queryScalar();
            if ($exists === false) {
                $this->db->createCommand()
                    ->insert($this->sessionTable, [
                        'id' => $id,
                        'data' => $data,
                        'expire' => $expire,
                        'user_id' => $userId,
                    ])->execute();
            } else {
                $this->db->createCommand()
                    ->update($this->sessionTable, ['data' => $data, 'expire' => $expire, 'user_id' => $userId], ['id' => $id])
                    ->execute();
            }
        } catch (\Exception $e) {
            $exception = ErrorHandler::convertExceptionToString($e);
            // its too late to use Yii logging here
            error_log($exception);
            echo $exception;

            return false;
        }

        return true;
    }

}
