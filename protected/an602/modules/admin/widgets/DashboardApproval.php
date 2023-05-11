<?php

namespace an602\modules\admin\widgets;

use an602\modules\admin\models\UserApprovalSearch;

/**
 * Shows pending approvals on dashboard
 *
 * @package an602.modules_core.admin.widgets
 * @since 0.7
 * @author Luke
 */
class DashboardApproval extends \an602\components\Widget
{

    public function run()
    {
        $users = new UserApprovalSearch();
        if ($users->search()->getCount() !== 0) {
            return $this->render('dashboardApproval', []);
        }
    }

}
