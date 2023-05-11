<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\file\handler;

use Yii;

/**
 * FileHandlerCollection
 *
 * @since 1.2
 * @author Luke
 */
class FileHandlerCollection extends \yii\base\Component
{

    /**
     * @event the init event - use to register file handlers
     */
    const EVENT_INIT = 'init';

    /**
     * Collection Types
     */
    const TYPE_VIEW = 'view';
    const TYPE_IMPORT = 'import';
    const TYPE_EXPORT = 'export';
    const TYPE_CREATE = 'create';
    const TYPE_EDIT = 'edit';

    /**
     * @var string current collection type
     */
    public $type;

    /**
     * @var \an602\modules\file\models\File
     */
    public $file = null;

    /**
     * @var BaseFileHandler[]
     */
    public $handlers = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->trigger(self::EVENT_INIT);

        // Register Core Handler
        if ($this->type === self::TYPE_EXPORT) {
            $this->register(Yii::createObject(['class' => DownloadFileHandler::class]));
        }

        $this->sortHandler();
    }

    /**
     * @param \an602\modules\file\components\BaseFileHandler $handler
     */
    public function register(BaseFileHandler $handler)
    {
        $handler->file = $this->file;
        $this->handlers[] = $handler;
    }

    /**
     * Returns registered handlers by type
     *
     * @param string|array $type or multiple type array
     * @param \an602\modules\file\models\File $file the file (optional)
     * @return BaseFileHandler[] the registered handlers
     */
    public static function getByType($types, $file = null)
    {
        $handlers = [];

        if (!is_array($types)) {
            $types = [$types];
        }

        foreach ($types as $type) {
            $handlers = array_merge($handlers, Yii::createObject([
                        'class' => static::class,
                        'file' => $file,
                        'type' => $type
                    ])->handlers);
        }
        return $handlers;
    }

    /**
     * Sorts the registered handlers
     */
    protected function sortHandler()
    {
        usort($this->handlers, function(BaseFileHandler $a, BaseFileHandler $b) {
            return strcmp($a->position, $b->position);
        });
    }

}
