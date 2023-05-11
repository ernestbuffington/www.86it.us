<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2019 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\content\widgets\richtext;

use an602\libs\Markdown;

/**
 * Class PreviewMarkdown
 * @package an602\modules\content\widgets\richtext
 * @deprecated since 1.8 use `Richtext::convert()` for richtext or a parser from `an602\modules\content\widgets\richtext\converter` for
 * plain markdown parsing.
 */
class PreviewMarkdown extends Markdown
{
    protected function parseEntity($text)
    {
        // html entities e.g. &copy; &#169; &#x00A9;
        if (preg_match('/^&#?[\w\d]+;/', $text, $matches)) {
            return [['inlineHtml', $matches[0]], strlen($matches[0])];
        } else {
            return [['text', '&'], 1];
        }
    }
}
