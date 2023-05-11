<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2021 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace content\functional;

use content\FunctionalTester;
use an602\modules\comment\models\forms\CommentForm;
use an602\modules\file\models\File;
use an602\modules\post\models\Post;
use yii\symfonymailer\Message;

class RichTextToEmailHtmlConverterCest
{

    public function testSendEmailWithImageAndLink(FunctionalTester $I)
    {
        $I->wantTo('see image and link in email message');
        $I->amUser1();

        $file = $this->createFile();
        $link = ['url' => 'http://an602.local/index.html', 'text' => 'Test Link Text'];
        $this->createComment($file, $link);

        $I->assertMailSent(1);

        /** @var Message $mail */
        $mail = $I->grabLastSentEmail();

        $commentMailText = $mail->getHtmlBody();

        if (!$this->tokenIsDetectedInImageUrl($commentMailText)) {
            $I->see('Token is not detected in image URL');
        }

        if (!$this->linkIsDetectedInEmail($commentMailText, $link)) {
            $I->see('Link is not detected in email message');
        }

        if (!$this->linkedImageIsDetectedInEmail($commentMailText, $link)) {
            $I->see('Linked image is not detected in email message');
        }
    }

    protected function tokenIsDetectedInImageUrl(string $emailMessage): bool
    {
        return (bool)preg_match('/with image[ =\r\n]+<img.+?src=".+?&amp;token=.+?".+?>/is', $emailMessage);
    }

    protected function linkIsDetectedInEmail(string $emailMessage, array $link): bool
    {
        return (bool)preg_match('/with link <a href="' . preg_quote($link['url'], '/') . '".+?> ' . preg_quote($link['text'], '/') . ' <\/a>/is', $emailMessage);
    }

    protected function linkedImageIsDetectedInEmail(string $emailMessage, array $link): bool
    {
        return (bool)preg_match('/with linked image <a href="' . preg_quote($link['url'], '/') . '".+?> <img.+?src=".+?&amp;token=.+?".+?> <\/a>/is', $emailMessage);
    }

    protected function createFile(): File
    {
        $file = new File([
            'file_name' => 'text.jpg',
            'title' => 'Test Image',
            'mime_type' => 'image/jpeg',
            'size' => 302176
        ]);
        $file->save();

        return $file;
    }

    protected function createComment(File $file, array $link)
    {
        $post = Post::findOne(['id' => 2]);
        $commentForm = new CommentForm($post);
        $commentForm->load([
            'objectModel' => get_class($post),
            'objectId' => $post->id,
            'Comment' => ['message' =>
                'Test comment with image ![' . $file->file_name . '](file-guid:' . $file->guid . ' "' . $file->title . '") ' .
                'and with link [' . $link['text'] . '](' . $link['url'] . ')' .
                'and with linked image [![' . $file->file_name . '](file-guid:' . $file->guid . ' "' . $file->title . '")](' . $link['url'] . ')'
            ],
            'fileList' => [$file->guid],
        ]);
        $commentForm->save();
    }

}
