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
use Yii;

/**
 * Class Telegram
 * @package onmotion\telegram
 */
class Telegram extends \yii\base\Widget
{

    public static $tlgrmChatId = null;

    public function init()
    {
        if (empty(\Yii::$app->i18n->translations['tlgrm'])) {
            \Yii::$app->i18n->translations['tlgrm'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => __DIR__ . '/messages',
                //'forceTranslation' => true,
            ];
        }

        parent::init();
    }

    public function run()
    {
        $view = $this->getView();
        TelegramAsset::register($view);
        $this->renderInitiateBtn();
    }
    

    private function renderInitiateBtn()
    {
        include (__DIR__ . '/views/default/button.php');
    }

}