<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\components\rendering;

/**
 * MailLayoutRenderer extends the LayoutRenderer with a renderText function.
 *
 * @author buddha
 * @since 1.2
 */
class MailLayoutRenderer extends LayoutRenderer
{
    public $subPath = 'mails';

    /**
     * @var string Layout file path
     */
    public $textLayout;

    /**
     * Used for rendering text mail content, by embedding the rendered view into
     * a $textLayout and removing all html elemtns.
     *
     * @param \an602\components\rendering\Viewable $viewable
     * @return string
     */
    public function renderText(Viewable $viewable, $params = [])
    {
        $textRenderer = new LayoutRenderer([
            'subPath' => $this->subPath . '/plaintext',
            'parent' => $this->parent,
            'layout' => $this->getTextLayout($viewable)
        ]);

        // exclude the view only embed the viewable text to the textlayout.
        $params['content'] = $viewable->text();

        return html_entity_decode(strip_tags($textRenderer->render($viewable, $params)));
    }

    /**
     * Returns the $textLayout for the given $viewable.
     *
     * @param \an602\components\rendering\Viewable $viewable
     * @return string
     */
    public function getTextLayout(Viewable $viewable)
    {
        return $this->textLayout;
    }
}
