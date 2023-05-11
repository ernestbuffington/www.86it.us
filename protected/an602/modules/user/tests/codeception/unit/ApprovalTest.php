<?php

namespace tests\codeception\unit;

use an602\modules\admin\models\UserApprovalSearch;
use tests\codeception\_support\an602DbTestCase;

class ApprovalTest extends an602DbTestCase
{

    /**
     * Tests user approval for 1 user without group assignment and one user with group assignment.
     */
    public function testAdminApproval()
    {
        $this->becomeUser('Admin');

        $approvalSearch = new UserApprovalSearch();
        $users = $approvalSearch->search()->getModels();

        $this->assertEquals(2, count($users));
    }

    /**
     * Tests user approval group manager.
     */
    public function testManagerApproval()
    {
        $this->becomeUser('User2');

        $approvalSearch = new UserApprovalSearch();
        $users = $approvalSearch->search()->getModels();

        $this->assertEquals(1, count($users));
    }

    /**
     * Tests user approval for non group manager.
     */
    public function testNonManagerApproval()
    {
        $this->becomeUser('User1');

        $approvalSearch = new UserApprovalSearch();
        $users = $approvalSearch->search()->getModels();

        $this->assertEquals(0, count($users));
    }
}
