<?php
/**
 * @copyright Copyright &copy; Alexandr Kozhevnikov (onmotion)
 * @package yii2-telegram
 * Date: 02.08.2016
 */

namespace onmotion\telegram\controllers;

use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Telegram;
use yii\base\UserException;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

define('API_KEY', \Yii::$app->modules['telegram']->API_KEY);
define('BOT_NAME', \Yii::$app->modules['telegram']->BOT_NAME);
define('hook_url', \Yii::$app->modules['telegram']->hook_url);
define('PASSPHRASE', \Yii::$app->modules['telegram']->PASSPHRASE);


/**
 * Default controller for the `telegram` module
 */
class DefaultController extends Controller
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'destroy-chat' => ['post'],
                    'init-chat' => ['post'],
                    'hook' => ['post'],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {            
        if ($action->id == 'hook') {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    public function actionDestroyChat()
    {
        return $this->renderPartial('button');
    }
    public function actionInitChat()
    {
        $session = \Yii::$app->session;
        if(!$session->has('tlgrm_chat_id')) {
            if (isset($_COOKIE['tlgrm_chat_id'])) {
                $tlgrmChatId = $_COOKIE['tlgrm_chat_id'];
                $session->set('tlgrm_chat_id', $tlgrmChatId);
            } else {
                $tlgrmChatId = uniqid();
                $session->set('tlgrm_chat_id', $tlgrmChatId);
                setcookie("tlgrm_chat_id", $tlgrmChatId, time() + 1800);
            }
        }
        return $this->renderPartial('chat');
    }

    public function actionSetWebhook(){
        try {
            // Create Telegram API object
            $telegram = new Telegram(API_KEY, BOT_NAME);

            if (!empty(\Yii::$app->modules['telegram']->userCommandsPath)){
                if(!$commandsPath = realpath(\Yii::getAlias(\Yii::$app->modules['telegram']->userCommandsPath))){
                    $commandsPath = realpath(\Yii::getAlias('@app') . \Yii::$app->modules['telegram']->userCommandsPath);
                }
                if(!is_dir($commandsPath)) throw new UserException('dir ' . \Yii::$app->modules['telegram']->userCommandsPath . ' not found!');
            }
            
            // Set webhook
            $result = $telegram->setWebHook(hook_url);
            if ($result->isOk()) {
                echo $result->getDescription();
            }
        } catch (TelegramException $e) {
            echo $e->getMessage();
        }
        return null;
    }
    public function actionUnsetWebhook(){
        if (\Yii::$app->user->isGuest) throw new ForbiddenHttpException();
        try {
            // Create Telegram API object
            $telegram = new Telegram(API_KEY, BOT_NAME);

            // Unset webhook
            $result = $telegram->unsetWebHook();

            if ($result->isOk()) {
                echo $result->getDescription();
            }
        } catch (TelegramException $e) {
            echo $e->getMessage();
        }
    }

    public function actionHook(){
        try {
            // Create Telegram API object
            $telegram = new Telegram(API_KEY, BOT_NAME);
            $basePath = \Yii::$app->getModule('telegram')->basePath;
//            $commandsPath = realpath($basePath . '/Commands/SystemCommands');
            $commandsPath = realpath($basePath . '/Commands/UserCommands');
            $telegram->addCommandsPath($commandsPath);
            if (!empty(\Yii::$app->modules['telegram']->userCommandsPath)){
                if(!$commandsPath = realpath(\Yii::getAlias(\Yii::$app->modules['telegram']->userCommandsPath))){
                    $commandsPath = realpath(\Yii::getAlias('@app') . \Yii::$app->modules['telegram']->userCommandsPath);
                }
                $telegram->addCommandsPath($commandsPath);
            }
            // Handle telegram webhook request
            $telegram->handle();
        } catch (TelegramException $e) {
            // Silence is golden!
            // log telegram errors
            var_dump($e->getMessage());
        }
        return null;
    }
}
