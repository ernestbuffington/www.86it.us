<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\admin\controllers;

use an602\modules\admin\components\Controller;
use an602\modules\admin\components\DatabaseInfo;
use an602\modules\admin\libs\an602API;
use an602\modules\queue\driver\MySQL;
use an602\modules\queue\helpers\QueueHelper;
use an602\modules\queue\interfaces\QueueInfoInterface;
use an602\modules\search\jobs\RebuildIndex;
use ReflectionClass;
use ReflectionException;
use Yii;

/**
 * Informations
 *
 * @since 0.5
 */
class InformationController extends Controller
{

    /**
     * @inheritdoc
     */
    public $adminOnly = false;

    /**
     * @inheritdoc
     */
    public $defaultAction = 'about';

    public function init()
    {
        $this->subLayout = '@admin/views/layouts/information';
        return parent::init();
    }

    /**
     * @inheritdoc
     */
    public function getAccessRules()
    {
        return [
            ['permissions' => \an602\modules\admin\permissions\SeeAdminInformation::class],
        ];
    }

    public function actionAbout()
    {
        $this->appendPageTitle(Yii::t('AdminModule.base', 'About'));
        $isNewVersionAvailable = false;
        $isUpToDate = false;

        $latestVersion = an602API::getLatestan602Version();
        if ($latestVersion) {
            $isNewVersionAvailable = version_compare($latestVersion, Yii::$app->version, ">");
            $isUpToDate = !$isNewVersionAvailable;
        }

        return $this->render('about', [
            'currentVersion' => Yii::$app->version,
            'latestVersion' => $latestVersion,
            'isNewVersionAvailable' => $isNewVersionAvailable,
            'isUpToDate' => $isUpToDate,
        ]);
    }

    public function actionPrerequisites()
    {
        return $this->render('prerequisites', ['checks' => \an602\libs\SelfTest::getResults()]);
    }

    public function actionDatabase()
    {
        $databaseInfo = new DatabaseInfo(Yii::$app->db->dsn);

        $rebuildSearchJob = new RebuildIndex();
        if (Yii::$app->request->isPost && Yii::$app->request->get('rebuildSearch') == 1) {
            Yii::$app->queue->push($rebuildSearchJob);
        }

        return $this->render(
            'database',
            [
                'rebuildSearchRunning' => QueueHelper::isQueued($rebuildSearchJob),
                'databaseName' => $databaseInfo->getDatabaseName(),
                'migrate' => \an602\commands\MigrateController::webMigrateAll(),
            ]
        );
    }

    /**
     * Caching Options
     */
    public function actionBackgroundJobs()
    {
        $lastRunHourly = (int) Yii::$app->settings->getUncached('cronLastHourlyRun');
        $lastRunDaily = (int) Yii::$app->settings->getUncached('cronLastDailyRun');

        $queue = Yii::$app->queue;

        $canClearQueue = false;
        if ($queue instanceof MySQL) {
            $canClearQueue = true;
            if (Yii::$app->request->isPost && Yii::$app->request->get('clearQueue') == 1) {
                $queue->clear();
                $this->view->setStatusMessage('success', Yii::t('AdminModule.information', 'Queue successfully cleared.'));
            }
        }

        $waitingJobs = null;
        $delayedJobs = null;
        $doneJobs = null;
        $reservedJobs = null;

        if ($queue instanceof QueueInfoInterface) {
            /** @var QueueInfoInterface $queue */
            $waitingJobs = $queue->getWaitingJobCount();
            $delayedJobs = $queue->getDelayedJobCount();
            $doneJobs = $queue->getDoneJobCount();
            $reservedJobs = $queue->getReservedJobCount();
        }

        $driverName = null;
        try {
            $reflect = new ReflectionClass($queue);
            $driverName = $reflect->getShortName();
        } catch (ReflectionException $e) {
            Yii::error('Could not determine queue driver: '. $e->getMessage());
        }

        return $this->render('background-jobs', [
            'lastRunHourly' => $lastRunHourly,
            'lastRunDaily' => $lastRunDaily,
            'waitingJobs' => $waitingJobs,
            'delayedJobs' => $delayedJobs,
            'doneJobs' => $doneJobs,
            'reservedJobs' => $reservedJobs,
            'driverName' => $driverName,
            'canClearQueue' => $canClearQueue
        ]);
    }

}
