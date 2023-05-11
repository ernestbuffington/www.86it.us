<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2018 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace comment\acceptance;

use comment\AcceptanceTester;

class CommentCest
{
    /**
     * @param AcceptanceTester $I
     * @throws \Exception
     */
    public function testCreateComment(AcceptanceTester $I)
    {
        $I->amUser1();
        $I->amOnSpace2();
        $I->waitForText('Admin Space 2 Post Private');

        $postEntry = '.wall_an602modulespostmodelsPost_13';
        $commentSection  = $postEntry.' .comment-container';

        $I->click('Comment', $postEntry);
        $I->wait(1);

        $I->click('.btn-comment-submit', $commentSection);

        $I->waitForText('The comment must not be empty!',null, $commentSection);

        $I->fillField($commentSection.' .an602-ui-richtext[contenteditable]', 'Test comment');

        $I->click('.btn-comment-submit', $commentSection);

        $I->waitForElementVisible('#comment-message-1');
        $I->see('Test comment','#comment-message-1');
        $I->dontSee('The comment must not be empty!',null, $commentSection);
    }
}
