<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2017 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\activity\interfaces;

/**
 * Interface for configurable activities
 *
 * All activities which implements this interface can be switched of by the user
 * or admin in e-mail summaries.
 *
 * @version 1.2
 * @author Luke
 */
interface ConfigurableActivityInterface
{

    /**
     * Returns the title of the activity, which is displayed on the configuration page.
     *
     * @return string the title of the activity
     */
    public function getTitle();

    /**
     * Returns the description of the activity, which is displayed on the configuration page.
     *
     * @return string the description of the activity
     */
    public function getDescription();

}
