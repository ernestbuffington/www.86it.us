<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2015 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\content\controllers;

use Yii;
use an602\components\Controller;
use an602\modules\content\models\WallEntry;
use an602\modules\content\models\Content;
use yii\web\HttpException;

/**
 * PermaController is used to create permanent links to content.
 *
 * @package an602.modules_core.wall.controllers
 * @since 0.5
 * @author Luke
 */
class PermaController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'acl' => [
                'class' => \an602\components\behaviors\AccessControl::class,
                'guestAllowedActions' => ['index', 'wall-entry']
            ]
        ];
    }

    /**
     * Redirects to given HActiveRecordContent or HActiveRecordContentAddon
     */
    public function actionIndex()
    {
        $id = (int)Yii::$app->request->get('id');
        $commentId = (int)Yii::$app->request->get('commentId');

        $content = Content::findOne(['id' => $id]);
        if ($content !== null) {

            if (method_exists($content->getPolymorphicRelation(), 'getUrl')) {
                $url = $content->getPolymorphicRelation()->getUrl();
            } elseif ($content->container !== null) {
                $urlParams = ['contentId' => $id];
                if ($commentId) {
                    $urlParams['commentId'] = $commentId;
                }
                $url = $content->container->createUrl(null, $urlParams);
            }

            if (!empty($url)) {
                return $this->redirect($url);
            }
        }

        throw new HttpException(404, Yii::t('ContentModule.base', 'Could not find requested content!'));
    }
}
