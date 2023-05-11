<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\content\components;

use an602\components\Controller;
use an602\modules\content\models\ContentContainer;
use an602\modules\space\models\Space;
use an602\modules\user\helpers\AuthHelper;
use an602\modules\user\models\User;
use Yii;
use yii\web\HttpException;

/**
 * Controller is the base class of web controllers which acts in scope of a ContentContainer (e.g. Space or User).
 *
 * To automatically load the current contentcontainer the containers guid must be passed as GET parameter 'cguid'.
 * You can create URLs in the scope of an ContentContainer by passing the contentContainer instance as 'container' or 'contentContainer'
 * as parameter to the URLManager.
 *
 * Example:
 *
 * ```
 * $url = Url::to(['my/action', 'container' => $this->contentContainer');
 * ```
 *
 * Based on the current ContentContainer a behavior (defined in ContentContainerActiveRecord::controllerBehavior) will be automatically
 * attached to this controller instance.
 * The attached behavior will perform basic access checks, adds the container sublayout and perform other tasks
 * (e.g. the space behavior will update the last visit membership attribute).
 *
 * @mixin \an602\modules\space\behaviors\SpaceController
 * @mixin \an602\modules\user\behaviors\ProfileController
 */
class ContentContainerController extends Controller
{

    /**
     * Specifies if a contentContainer (e.g. Space or User) is required to run this controller.
     * Set this to false, if your controller should also act on global scope.
     *
     * @var boolean require cguid container parameter
     */
    public $requireContainer = true;

    /**
     * @var ContentContainerActiveRecord the content container (e.g. Space or User record)
     */
    public $contentContainer = null;

    /**
     * Limit this controller only for usage on given contentcontainer types (e.g. Space).
     *
     * @since 1.3
     * @var array|null an array of valid content container classes. if null all container types (User & Space) are allowed.
     */
    public $validContentContainerClasses = null;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // Load the ContentContainer
        $guid = Yii::$app->request->get('cguid', Yii::$app->request->get('sguid', Yii::$app->request->get('uguid')));
        $this->contentContainer = $this->getContentContainerByGuid($guid);


        if ($this->validContentContainerClasses !== null) {
            if ($this->contentContainer === null || !in_array($this->contentContainer->className(), $this->validContentContainerClasses)) {
                throw new HttpException(400);
            }
        }

        if ($this->contentContainer !== null && $this->contentContainer->controllerBehavior) {
            $this->attachBehavior('containerControllerBehavior', ['class' => $this->contentContainer->controllerBehavior]);
        }

        if ($this->contentContainer !== null && $this->contentContainer->isBlockedForUser()) {
            throw new HttpException(400, 'You are blocked for this page!');
        }
    }


    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        // Directly redirect guests to login page - if guest access isn't enabled
        if (Yii::$app->user->isGuest && !AuthHelper::isGuestAccessEnabled()) {
            Yii::$app->user->loginRequired();
            return false;
        }

        if ($this->requireContainer && $this->contentContainer === null) {
            throw new HttpException(404, Yii::t('base', 'Could not find requested page.'));
        }

        $this->checkModuleIsEnabled();

        if ($this->contentContainer) {
            $this->view->registerJsConfig('content.container', [
                'guid' => $this->contentContainer->guid
            ]);
        } else {
            $this->view->registerJsConfig('content.container', [
                'guid' => null
            ]);
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function getAccess()
    {
        return new ContentContainerControllerAccess(['contentContainer' => $this->contentContainer]);
    }

    /**
     * Checks if the requested module is available in this contentContainer.
     *
     * @throws HttpException if the module is not enabled
     */
    protected function checkModuleIsEnabled()
    {
        if ($this->module instanceof ContentContainerModule && $this->contentContainer !== null &&
            !$this->contentContainer->moduleManager->isEnabled($this->module->id)) {
            throw new HttpException(405, Yii::t('base', 'Module is not enabled on this content container!'));
        }
    }

    /**
     * @param string|null $guid
     * @return ContentContainerActiveRecord|null
     */
    private function getContentContainerByGuid(?string $guid): ?ContentContainerActiveRecord
    {
        if (empty($guid)) {
            return null;
        }

        $contentContainer = ContentContainer::findOne(['guid' => $guid]);
        if ($contentContainer === null) {
            return null;
        }

        /* @var Space|User $contentContainerClass */
        $contentContainerClass = $contentContainer->class;

        return $contentContainerClass::find()->where(['guid' => $guid])->one();
    }
}
