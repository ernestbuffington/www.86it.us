<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\admin\controllers;

use an602\components\export\DateTimeColumn;
use an602\components\export\SpreadsheetExport;
use an602\modules\admin\components\Controller;
use an602\modules\admin\models\PendingRegistrationSearch;
use an602\modules\admin\permissions\ManageGroups;
use an602\modules\admin\permissions\ManageUsers;
use an602\modules\user\models\Invite;
use Yii;
use yii\web\HttpException;

class PendingRegistrationsController extends Controller
{

    /**
     * @inheritDoc
     */
    public function init()
    {
        $this->subLayout = '@admin/views/layouts/user';
        $this->appendPageTitle(Yii::t('AdminModule.base', 'Pending user registrations'));

        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function getAccessRules()
    {
        return [
            [
                'permission' => [
                    ManageUsers::class,
                    ManageGroups::class,
                ]
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function actionIndex()
    {
        $searchModel = new PendingRegistrationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'types' => [
                null => null,
                PendingRegistrationSearch::SOURCE_INVITE => Yii::t('AdminModule.base', 'Invite by email'),
                PendingRegistrationSearch::SOURCE_INVITE_BY_LINK => Yii::t('AdminModule.base', 'Invite by link'),
                PendingRegistrationSearch::SOURCE_SELF => Yii::t('AdminModule.base', 'Sign up'),
            ]
        ]);
    }

    /**
     * Export user list as csv or xlsx
     *
     * @param string $format supported format by phpspreadsheet
     * @return \yii\web\Response
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     * @throws \yii\base\Exception
     */
    public function actionExport($format)
    {
        $searchModel = new PendingRegistrationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $exporter = new SpreadsheetExport([
            'dataProvider' => $dataProvider,
            'columns' => $this->collectExportColumns(),
            'resultConfig' => [
                'fileBaseName' => 'an602_user',
                'writerType' => $format,
            ],
        ]);

        return $exporter->export()->send();
    }

    /**
     * Resend a invite
     *
     * @param integer $id
     * @return string
     * @throws HttpException
     */
    public function actionResend($id)
    {
        $this->forcePostRequest();
        $invite = $this->findInviteById($id);
        if (Yii::$app->request->isPost) {
            $invite->sendInviteMail();
            $this->view->success(Yii::t(
                'AdminModule.user',
                'Resend invitation email'
            ));
            return $this->redirect(['index']);
        }
        return $this->render('resend', ['model' => $invite]);
    }

    /**
     * Delete an invite
     *
     * @param integer $id
     * @return string
     * @throws HttpException
     * @throws \Throwable
     */
    public function actionDelete($id)
    {
        $this->forcePostRequest();
        $invite = $this->findInviteById($id);
        if (Yii::$app->request->isPost) {
            $invite->delete();
            $this->view->success(Yii::t(
                'AdminModule.user',
                'Deleted invitation'
            ));
            return $this->redirect(['index']);
        }
        return $this->render('delete', ['model' => $invite]);
    }

    /**
     * Delete all invitations
     *
     * @param integer $id
     * @return string
     * @throws HttpException
     * @throws \Throwable
     */
    public function actionDeleteAll()
    {
        if (Yii::$app->request->isPost) {
            Invite::deleteAll();

            $this->view->success(Yii::t(
                'AdminModule.user',
                'All open registration invitations were successfully deleted.'
            ));
        }
        return $this->redirect(['index']);
    }

    /**
     * Delete all or selected invitation
     *
     * @param integer $id
     * @return string
     * @throws HttpException
     * @throws \Throwable
     */
    public function actionDeleteAllSelected()
    {
        if (Yii::$app->request->isPost) {

            $ids = Yii::$app->request->post('id');
            if (!empty($ids)) {
                foreach ($ids as $id) {
                    $invitation = Invite::findOne(['id' => $id]);
                    $invitation->delete();
                }
                $this->view->success(Yii::t(
                    'AdminModule.user',
                    'The selected invitations have been successfully deleted!'
                ));
            }
        }
        return $this->redirect(['index']);
    }

    /**
     * Return array with columns for data export
     * @return array
     */
    private function collectExportColumns()
    {
        return [
            'id',
            'user_originator_id',
            'space_invite_id',
            'email',
            'source',
            [
                'class' => DateTimeColumn::class,
                'attribute' => 'created_at',
            ],
            'created_by',
            [
                'class' => DateTimeColumn::class,
                'attribute' => 'updated_at',
            ],
            'updated_by',
            'language',
            'firstname',
            'lastname',
        ];
    }

    /**
     * Find invite by id
     * @param $id
     * @return Invite|null
     * @throws HttpException
     */
    private function findInviteById($id)
    {
        $invite = Invite::findOne(['id' => $id]);
        if ($invite === null) {
            throw new HttpException(404, Yii::t(
                'AdminModule.user',
                'Invite not found!'
            ));
        }
        return $invite;
    }
}
