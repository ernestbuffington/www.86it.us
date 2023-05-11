<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */


namespace an602\components\access;

class DelegateAccessValidator extends ActionAccessValidator
{
    public $owner;

    public $handler;

    /**
     * @var string Name of callback method to run after failed validation
     * @since 1.8
     */
    public $codeCallback;
    
    /**
     * @inheritDoc
     */
    protected function validate($rule)
    {
        $handler = $this->handler;
        return $this->owner->$handler($rule, $this);
    }
}
