<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2016 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\content\widgets;

use an602\modules\content\models\forms\AdminDeleteContentForm;

/**
 * Admin Delete Modal for Wall Entries
 *
 * This widget will be shown when admin deletes someone's content
 *
 */
class AdminDeleteModal extends \yii\base\Widget
{
    /**
     * @var AdminDeleteContentForm
     */
    public $model = null;

    /**
     * Executes the widget.
     */
    public function run()
    {
        return $this->render('adminDeleteModal', [
            'model' => $this->model,
        ]);
    }
}
