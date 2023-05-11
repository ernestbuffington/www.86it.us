<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2015 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\widgets;

use Exception;

/**
 * MarkdownViewWidget shows Markdown flavored content
 *
 * @author luke
 * @since 0.11
 */
class MarkdownView extends \yii\base\Widget
{

    /**
     * Markdown to parse
     *
     * @var string
     */
    public $markdown = "";

    /**
     * Markdown parser class
     *
     * @var string
     */
    public $parserClass = "an602\libs\Markdown";

    /**
     * Purify output after parsing
     *
     * @var boolean
     */
    public $purifyOutput = true;

    /**
     * Stylesheet for Highlight.js
     */
    public $highlightJsCss = "github";

    /**
     * @var boolean return plain output (do not use widget template)
     */
    public $returnPlain = false;

    public function init()
    {
        if (!\an602\libs\Helpers::CheckClassType($this->parserClass, "cebe\markdown\Parser")) {
            throw new Exception("Invalid markdown parser class given!");
        }
    }

    public function run()
    {
        $this->markdown = \yii\helpers\Html::encode($this->markdown);

        $parserClass = $this->parserClass;

        $parser = new $parserClass;
        $html = $parser->parse($this->markdown);

        if ($this->purifyOutput) {
            $html = \yii\helpers\HtmlPurifier::process($html, function ($config) {
                        $config->set('URI.AllowedSchemes', ['http' => true, 'https' => true, 'mailto' => true, 'ftp' => true, 'file' => true]);
                        $config->getHTMLDefinition(true)
                                ->addAttribute('a', 'target', 'Text');
                    });
        }

        if ($this->returnPlain) {
            return $html;
        }

        return $this->render('markdownView', ['content' => $html, 'highlightJsCss' => $this->highlightJsCss]);
    }

}
