<?php
    use yii\helpers\Url;

?>
<li>
    <?php
    $offLinkId = 'notification_off_' . $content->id;
    $onLinkId = 'notification_on_' . $content->id;

    echo \an602\widgets\AjaxButton::widget([
        'tag' => 'a',
        'label' => '<i class="fa fa-bell-slash-o"></i> ' . Yii::t('ContentModule.base', 'Turn off notifications'),
        'ajaxOptions' => [
            'type' => 'POST',
            'data' => ['_method' => 'POST'], // Need to set this for case when it is inside <form> (e.g. cfiles - browse table)
            'success' => "function(res){ if (res.success) { $('#" . $offLinkId . "').hide(); $('#" . $onLinkId . "').show(); } }",
            'url' => Url::to(['/content/content/notification-switch', 'id' => $content->id, 'switch' => 0]),
        ],
        'htmlOptions' => [
            'class' => 'turnOffNotifications',
            'style' => 'display: ' . ($state ? 'block' : 'none'),
            'href' => '#',
            'id' => $offLinkId
        ]
    ]);

    echo \an602\widgets\AjaxButton::widget([
        'tag' => 'a',
        'label' => '<i class="fa fa-bell-o"></i> ' . Yii::t('ContentModule.base', 'Turn on notifications'),
        'ajaxOptions' => [
            'type' => 'POST',
            'data' => ['_method' => 'POST'], // Need to set this for case when it is inside <form> (e.g. cfiles - browse table)
            'success' => "function(res){ if (res.success) { $('#" . $onLinkId . "').hide(); $('#" . $offLinkId . "').show(); } }",
            'url' => Url::to(['/content/content/notification-switch', 'id' => $content->id, 'switch' => 1]),
        ],
        'htmlOptions' => [
            'class' => 'turnOnNotifications',
            'style' => 'display: ' . ($state ? 'none' : 'block'),
            'href' => '#',
            'id' => $onLinkId
        ]
    ]);
    ?>
</li>
