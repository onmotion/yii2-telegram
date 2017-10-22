<?php
/**
 * @copyright Copyright &copy; Alexandr Kozhevnikov (onmotion)
 * @package yii2-telegram
 * Date: 02.08.2016
 */

namespace onmotion\telegram;

use yii\base\UserException;
use yii\helpers\Url;

/**
 * telegram module definition class
 */
class Module extends \yii\base\Module implements \yii\base\BootstrapInterface
{
    public $API_KEY = null;
    public $BOT_NAME = null;
    public $hook_url = null;
    public $PASSPHRASE = null;
    public $userCommandsPath = null;
    public $timeBeforeResetChatHandler = 0;
    public $db = 'db';
    public $options = [];

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

        // set up i8n
        if (empty(\Yii::$app->i18n->translations['tlgrm'])) {
            \Yii::$app->i18n->translations['tlgrm'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => __DIR__ . '/messages',
                //'forceTranslation' => true,
            ];
        }

        $this->options = [
            'initChat' => Url::to(['/telegram/default/init-chat']),
            'destroyChat' => Url::to(['/telegram/default/destroy-chat']),
            'getAllMessages' => Url::to(['/telegram/chat/get-all-messages']),
            'getLastMessages' => Url::to(['/telegram/chat/get-last-messages']),
            'initialMessage' => \Yii::t('tlgrm', 'Write your question...'),
        ];

    }

    public function bootstrap($app)
    {
        if ($app instanceof \yii\console\Application) {
            $this->controllerNamespace = 'onmotion\telegram\commands';
        }
    }
}
