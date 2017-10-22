<?php
/**
 * @copyright Copyright &copy; Alexandr Kozhevnikov (onmotion)
 * @package yii2-telegram
 * Date: 02.08.2016
 */

use yii\helpers\Html;

$options = [
    'initChat' => yii\helpers\Url::to(['telegram/default/init-chat']),
    'destroyChat' => yii\helpers\Url::to(['telegram/default/destroy-chat']),
    'getAllMessages' => yii\helpers\Url::to(['telegram/chat/get-all-messages']),
    'getLastMessages' => yii\helpers\Url::to(['telegram/chat/get-last-messages']),
    'initialMessage' => Yii::t('tlgrm', 'Write your question...'),
];

echo Html::button('<i class="glyphicon glyphicon-send"></i> <span>' . Yii::t('tlgrm', 'Online support') . '</span>', ['class' => 'btn btn-primary', 'id' => 'tlgrm-init-btn']);
?>
<script>
    var telegramOptions = <?= \yii\helpers\Json::htmlEncode($options) ?>;
</script>