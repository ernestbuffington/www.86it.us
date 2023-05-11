<?php

namespace tests\codeception\unit;

use an602\libs\EmojiMap;
use tests\codeception\_support\an602DbTestCase;

class EmojiTest extends an602DbTestCase
{
    /**
     * Make sure users with create topic permission sees topic picker
     */
    public function testEmojiMapCoversAllRichtextEmojis()
    {
        $emoji = json_decode(file_get_contents(__dir__ . DIRECTORY_SEPARATOR .'emoji.json'), true);
        foreach ($emoji as $key => $def) {
            $this->assertArrayHasKey($key, EmojiMap::MAP);
        }
    }
}
