<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2016 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\widgets\mails;

use an602\modules\content\widgets\richtext\converter\RichTextToEmailHtmlConverter;
use Yii;
use an602\modules\content\widgets\richtext\converter\RichTextToHtmlConverter;
use an602\components\rendering\ViewPathRenderer;
use an602\components\rendering\Viewable;
use an602\modules\content\interfaces\ContentOwner;

/**
 * MailContentEntry renders a simple mail content with originator information and an
 * content block to simulate a wall entry as good as poosible.
 *
 * @author buddha
 * @since 1.2
 */
class MailContentEntry extends \yii\base\Widget
{

    /**
     * @var \an602\modules\user\models\User content originator
     */
    public $originator;

    /**
     * @var \an602\modules\user\models\User notification receiver
     */
    public $receiver;

    /**
     * @var string|Viewable|ContentOwner content to render
     */
    public $content;

    /**
     * @var \an602\modules\space\models\Space space of content (optional)
     */
    public $space;

    /**
     * @var string content date
     */
    public $date;

    /**
     * @var boolean will render the content as comment
     */
    public $isComment;

    /**
     * @inheritdoc
     */
    public function run()
    {
        $content = null;

        if (is_string($this->content)) {
            $content = $this->content;
        } elseif ($this->content instanceof Viewable) {
            try {
                $renderer = new ViewPathRenderer(['parent' => true, 'subPath' => 'mail']);
                $content =  $renderer->render($this->content);
            } catch (\yii\base\ViewNotFoundException $e) {
                Yii::error($e);
            }
        } elseif ($this->content instanceof ContentOwner) {
            $content = RichTextToEmailHtmlConverter::process($this->content->getContentDescription(), [
                RichTextToEmailHtmlConverter::OPTION_RECEIVER_USER => $this->receiver,
                RichTextToHtmlConverter::OPTION_CACHE_KEY => RichTextToHtmlConverter::buildCacheKeyForContent($this->content, 'mail_entry'),
            ]);

            if(!$this->originator) {
                $this->originator = $this->content->content->createdBy;
            }
        }

        return $this->render('mailContentEntry', [
                    'originator' => $this->originator,
                    'content' => $content,
                    'space' => $this->space,
                    'date' => $this->date,
                    'isComment' => $this->isComment,
        ]);
    }
}
?>
