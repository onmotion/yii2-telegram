<?php
/**
 * @copyright Copyright &copy; Alexandr Kozhevnikov (onmotion)
 * @package yii2-telegram
 * Date: 02.08.2016
 */

use yii\helpers\Html;

echo Html::beginTag('div', ['id' => 'tlgrm-chat']);
echo Html::beginTag('div', ['id' => 'tlgrm-chat-head']);
echo Html::beginTag('div', ['id' => 'tlgrm-chat-head-caption']);
echo '<i class="glyphicon glyphicon-send"></i> <span>' . Yii::t('tlgrm', 'Online support') . '</span>';
echo Html::endTag('div');
echo Html::tag('div', '',['id' => 'tlgrm-close-btn']);
echo Html::endTag('div');
echo Html::tag('div', '',['id' => 'tlgrm-chat-flow']);
echo Html::beginTag('div', ['id' => 'tlgrm-chat-send-panel']);
echo Html::beginForm(yii\helpers\Url::to(['/telegram/chat/send-msg']), 'post', ['id' => 'tlgrm-chat-form']);
echo Html::textarea('message', '', ['class' => "form-control", 'id' => 'tlgrm-chat-msg', 'minlength'=>"1", 'required' => 'required',]);
echo Html::submitButton('<i class="glyphicon glyphicon-send"></i>', ['class' => 'btn btn-primary', 'id' => 'tlgrm-send-btn']);
echo Html::endForm();
echo Html::endTag('div');
echo Html::endTag('div');