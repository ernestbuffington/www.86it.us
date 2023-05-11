<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\components\access;

use an602\modules\user\helpers\AuthHelper;
use Yii;

class GuestAccessValidator extends AccessValidator
{
    public $name = 'guestAccess';

    public $code = 403;

    /**
     * @inheritdoc
     */
    public function run()
    {
        if ($this->access->isGuest() && !AuthHelper::isGuestAccessEnabled()) {
            $this->code = 401;
            return false;
        }

        if (!$this->access->isGuest()) {
            return true;
        }

        // If there is a guest restriction rule only return true if there is an action related rule
        foreach ($this->filterRelatedRules() as $rule) {
            if ($this->isActionRelated($rule)) {
                return true;
            }
        }

        return false;
    }
}
