<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2015 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\space\modules\manage\widgets;

use yii\base\Widget;

/**
 * PendingApprovals show open member approvals to admin in sidebar
 *
 * @author Luke
 * @since 0.21
 */
class PendingApprovals extends Widget
{

    /**
     * @var \an602\modules\space\models\Space
     */
    public $space;

    /**
     * @var int number of applicants to show
     */
    public $maxApplicants = 15;

    /**
     * @inheritdoc
     */
    public function run()
    {
        // Only visible for admins
        if (!$this->space->isAdmin()) {
            return;
        }

        $applicants = $this->space->getApplicants()->limit($this->maxApplicants)->all();

        // No applicants
        if (count($applicants) === 0) {
            return;
        }

        return $this->render('pendingApprovals', ['applicants' => $applicants, 'space' => $this->space]);
    }

}
