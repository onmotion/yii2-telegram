<?php
/**
 * @copyright Copyright &copy; Alexandr Kozhevnikov (onmotion)
 * @package yii2-telegram
 * Date: 02.08.2016
 */

use yii\helpers\Html;
use Yii;

echo Html::button('<i class="glyphicon glyphicon-send"></i> ' . Yii::t('tlgrm', 'Online support'), ['class' => 'btn btn-primary', 'id' => 'tlgrm-init-btn']);