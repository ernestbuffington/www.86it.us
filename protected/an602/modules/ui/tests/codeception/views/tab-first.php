<?php
/**
 * @link https://metamz.network/
 * @copyright Copyright (c) 2021 H u m H u b GmbH & Co. KG, PHP-AN602, The 86it Developers Network, and Yii
 * @license https://www.metamz.network/licences
 */

use an602\modules\ui\form\widgets\ActiveForm;
use tests\codeception\models\TestTabbedFormModel;

/* @var $form ActiveForm */
/* @var $tabbedForm TestTabbedFormModel */
?>

<?= $form->field($tabbedForm, 'firstname')->textInput() ?>
<?= $form->field($tabbedForm, 'lastname')->textInput() ?>
<?= $form->field($tabbedForm, 'email')->textInput() ?>
