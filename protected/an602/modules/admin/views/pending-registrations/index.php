<?php

use an602\modules\admin\widgets\PendingRegistrations;

/** @var $searchModel \an602\modules\admin\models\PendingRegistrationSearch */
/** @var $dataProvider yii\data\ActiveDataProvider */
/** @var $types array */


?>

<div class="panel-body">
    <?=
    PendingRegistrations::widget([
        'dataProvider' => $dataProvider,
        'searchModel' => $searchModel,
        'types' => $types,
    ]);
    ?>
</div>
