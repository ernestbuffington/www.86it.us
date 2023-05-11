<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 *
 */

namespace activity\functional;

use an602\modules\activity\components\MailSummary;
use an602\modules\activity\models\MailSummaryForm;
use an602\modules\activity\tests\codeception\activities\TestActivity;
use an602\modules\content\activities\ContentCreated;
use an602\modules\post\models\Post;
use an602\modules\user\models\User;
use activity\FunctionalTester;

class ActivityLinkCest
{
    public function testSimpleActivityLink(FunctionalTester $I)
    {
        $I->wantTo('the activity link works');
        $I->amAdmin();

        (new MailSummaryForm(['interval' => MailSummary::INTERVAL_NONE]))->save();
        (new MailSummaryForm([
            'user' => User::findOne(['id' => 2]),
            'interval' => MailSummary::INTERVAL_DAILY,
            'activities' => [ContentCreated::class]
        ]))->save();

        $activity = TestActivity::instance()->about(Post::findOne(1))->create();

        $I->amOnRoute('/activity/link', ['id' => $activity->record->id]);
        $I->see('Account settings');
    }

    public function testNonViewableNotification(FunctionalTester $I)
    {
        $I->wantTo('the activity link works');
        $I->amAdmin();

        (new MailSummaryForm(['interval' => MailSummary::INTERVAL_NONE]))->save();
        (new MailSummaryForm([
            'user' => User::findOne(['id' => 2]),
            'interval' => MailSummary::INTERVAL_DAILY,
            'activities' => [ContentCreated::class]
        ]))->save();

        $activity = TestActivity::instance()->about(Post::findOne(1))->create();

        $I->amUser1(true);
        $I->amOnRoute('/activity/link', ['id' => $activity->record->id]);
        $I->seeResponseCodeIs(403);
    }
}
