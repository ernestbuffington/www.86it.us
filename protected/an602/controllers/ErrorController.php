<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\controllers;

use an602\modules\user\helpers\AuthHelper;
use Yii;
use yii\web\HttpException;
use yii\base\UserException;
use an602\components\Controller;

/**
 * ErrorController
 *
 * @author luke
 * @since 0.11
 */
class ErrorController extends Controller
{

    /**
     * This is the action to handle external exceptions.
     */
    public function actionIndex()
    {
        // Fix: https://github.com/an602/an602/issues/3848
        Yii::$app->view->theme->register();

        if (($exception = Yii::$app->getErrorHandler()->exception) === null) {
            return '';
        }

        if ($exception instanceof UserException || $exception instanceof HttpException) {
            $message = $exception->getMessage();
        } else {
            $message = Yii::t('error', 'An internal server error occurred.');
        }

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';
            return [
                'error' => true,
                'message' => $message
            ];
        }

        /**
         * Show special login required view for guests
         */
        if (Yii::$app->user->isGuest && $exception instanceof HttpException && $exception->statusCode == '401' && AuthHelper::isGuestAccessEnabled()) {
            return $this->render('@an602/views/error/401_guests', ['message' => $message]);
        }

        return $this->render('@an602/views/error/index', [
            'message' => $message
        ]);
    }
}
