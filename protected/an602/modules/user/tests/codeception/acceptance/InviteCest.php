<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2018 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace user\acceptance;

use tests\codeception\_pages\DirectoryMemberPage;
use user\AcceptanceTester;

class InviteCest
{
    /**
     * @param AcceptanceTester $I
     * @throws \Exception
     */
    public function testDashboardInviteByMail(AcceptanceTester $I)
    {
        $I->wantTo('ensure that inviting external users by mail form works.');

        $I->amUser();
        DirectoryMemberPage::openBy($I);

        $I->click('Invite new people');
        $I->waitForText('Invite new people', null, '#globalModal');

        $I->amGoingTo('invite an already existing user email');
        $I->fillField('#emails', 'user1@example.com');
        $I->click('Send invite', '#globalModal');
        $I->expectTo('see an error message');
        $I->waitForText('user1@example.com is already registered!');

        $I->amGoingTo('invite an non existing user email');
        $I->fillField('#emails', 'user1234@example.com');
        $I->click('Send invite', '#globalModal');
        $I->expectTo('see a confirm message');
        $I->seeSuccess();
    }
}
