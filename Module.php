<?php

namespace onmotion\telegram;
use yii\base\UserException;

/**
 * telegram module definition class
 */
class Module extends \yii\base\Module
{
    public $API_KEY = null;
    public $BOT_NAME = null;
    public $hook_url = null;
    public $PASSPHRASE = null;
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'onmotion\telegram\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        if (empty($this->API_KEY) || empty($this->BOT_NAME) || empty($this->hook_url))
            throw new UserException('You must set API_KEY, BOT_NAME, hook_url');
        if (empty($this->PASSPHRASE))
            throw new UserException('You must set PASSPHRASE');
        parent::init();

        $view = \Yii::$app->getView();
        TelegramAsset::register($view);
        // custom initialization code goes here
        \Yii::$app->getUrlManager()->addRules([
            '<module:telegram>/<action>' => 'telegram/default/<action>',
        ], false);
    }
}
