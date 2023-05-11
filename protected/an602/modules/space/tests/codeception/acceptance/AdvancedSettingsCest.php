<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2021 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace space\acceptance;

use space\AcceptanceTester;

class AdvancedSettingsCest
{
    public function testHideMembers(AcceptanceTester $I)
    {
        $I->amSpaceAdmin(false, 2);

        $I->amOnPage('/s/space-2/home');
        $I->seeElement('#space-members-panel');

        $I->amOnPage('/s/space-2/about');
        $I->seeElement('#space-members-panel');

        $I->amOnPage('/s/space-2/space/manage/default/advanced');
        $I->see('Members', '.statistics');
        $I->checkOption('#advancedsettings-hidemembers');
        $I->submitForm('#spaceIndexForm', []);

        $I->waitForText('Saved');
        $I->dontSee('Members', '.statistics');

        $I->amOnPage('/s/space-2/home');
        $I->dontSeeElement('#space-members-panel');

        $I->amOnPage('/s/space-2/about');
        $I->dontSeeElement('#space-members-panel');
    }

    public function testHideActivities(AcceptanceTester $I)
    {
        $I->amSpaceAdmin(false, 2);

        $I->amOnPage('/s/space-2/home');
        $I->seeElement('#panel-activities');

        $I->amOnPage('/s/space-2/space/manage/default/advanced');
        $I->checkOption('#advancedsettings-hideactivities');
        $I->submitForm('#spaceIndexForm', []);

        $I->waitForText('Saved');

        $I->amOnPage('/s/space-2/home');
        $I->dontSeeElement('#panel-activities');
    }

    public function testHideAbout(AcceptanceTester $I)
    {
        $I->amSpaceAdmin(false, 2);

        $I->amOnPage('/s/space-2/space/manage/default/advanced');
        $I->see('About', '#space-main-menu');

        $I->checkOption('#advancedsettings-hideabout');
        $I->submitForm('#spaceIndexForm', []);

        $I->waitForText('Saved');

        $I->dontSee('About', '#space-main-menu');
    }

    public function testHideFollowers(AcceptanceTester $I)
    {
        $I->amSpaceAdmin(false, 2);

        $I->amOnPage('/s/space-2/space/manage/default/advanced');
        $I->see('Followers', '.statistics');
        $I->checkOption('#advancedsettings-hidefollowers');
        $I->submitForm('#spaceIndexForm', []);

        $I->waitForText('Saved');
        $I->dontSee('Followers', '.statistics');
    }

}
