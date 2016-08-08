<?php
/**
 * Created by PhpStorm.
 * User: kozhevnikov
 * Date: 02.08.2016
 * Time: 15:52
 */

namespace onmotion\telegram;

use yii\web\AssetBundle;

class TelegramAsset extends AssetBundle
{
    public $sourcePath = __DIR__ . '/assets';
    public $css = [
        'css/telegram.css',
    ];
    public $js = [
        'js/telegram.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
