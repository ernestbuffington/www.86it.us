<?php

/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2016 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

namespace an602\modules\comment\widgets;

use an602\modules\comment\models\forms\AdminDeleteCommentForm;

/**
 * Admin Delete Modal for Comments
 *
 * This widget will be shown when admin deletes someone's comment
 *
 */
class AdminDeleteModal extends \yii\base\Widget
{
    /**
     * @var AdminDeleteCommentForm
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
