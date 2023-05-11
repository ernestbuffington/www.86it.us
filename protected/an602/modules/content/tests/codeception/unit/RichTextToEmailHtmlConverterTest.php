<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2021 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\content\tests\codeception\unit;

use an602\modules\content\widgets\richtext\converter\RichTextToEmailHtmlConverter;
use an602\modules\file\actions\DownloadAction;
use an602\modules\file\models\File;
use an602\modules\user\models\User;
use tests\codeception\_support\an602DbTestCase;

class RichTextToEmailHtmlConverterTest extends an602DbTestCase
{
    public function testEmailHtmlConverter()
    {
        $receiverUser = User::findOne(['id' => 1]);
        $postedFile = new File();
        $postedFile->save();

        // Check markdown image tag is converted to html tag with JWT token in params
        $sourceMessage = '![test.txt](file-guid:'.$postedFile->guid.' "test.txt")';
        $convertedMessage = RichTextToEmailHtmlConverter::process($sourceMessage, ['receiver' => $receiverUser]);
        $this->assertTrue($sourceMessage != $convertedMessage);

        // Grab token from the processed email message
        $tokenIsGenerated = preg_match('/<img src=".+&amp;token=(.+?)"/i', $convertedMessage, $parsedTokenData);
        $this->assertTrue((bool)$tokenIsGenerated);

        // Compare generated token with parsed from email message
        $parsedTokenFromEmailMessage = (isset($parsedTokenData[1]) ? $parsedTokenData[1] : null);
        $generatedToken = DownloadAction::generateDownloadToken($postedFile, $receiverUser);
        $this->assertEquals($parsedTokenFromEmailMessage, $generatedToken);

        // Make sure the User from token is same as receiver of the email message
        $tokenUser = DownloadAction::getUserByDownloadToken($parsedTokenFromEmailMessage, $postedFile);
        $this->assertEquals($tokenUser, $receiverUser);
    }
}
