<?php
/**
 * @copyright Copyright &copy; Alexandr Kozhevnikov (onmotion)
 * @package yii2-telegram
 * Date: 02.08.2016
 */
namespace onmotion\telegram;

use yii\helpers\Html;
use yii\web\Cookie;
use yii\widgets\ActiveForm;

/**
 * Class Telegram
 * @package onmotion\telegram
 */
class Telegram extends \yii\base\Widget
{

    public static $tlgrmChatId = null;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $view = $this->getView();
        TelegramAsset::register($view);
     //   $this->renderChat();
        $this->renderInitiateBtn();
    }
    

    private function renderInitiateBtn()
    {
        echo Html::button('<i class="glyphicon glyphicon-send"></i> Онлайн помощь', ['class' => 'btn btn-primary', 'id' => 'tlgrm-init-btn']);
    }

}