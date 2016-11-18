<?php
/**
 * @copyright Copyright &copy; Alexandr Kozhevnikov (onmotion)
 * @package yii2-telegram
 * Date: 02.08.2016
 */
namespace onmotion\telegram;

use yii\web\AssetBundle;

class TelegramAsset extends AssetBundle
{
   
    public function init()
    {
        $this->sourcePath = __DIR__ . '/assets';
        parent::init();
    }

    public $css = [
        'css/telegram.css',
    ];
    public $js = [
        'js/telegram.js',
        'js/jquery.nicescroll.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
