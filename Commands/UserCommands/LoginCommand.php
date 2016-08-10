<?php

namespace Longman\TelegramBot\Commands\UserCommands;

use onmotion\telegram\models\Actions;
use onmotion\telegram\models\AuthorizedManagerChat;
use onmotion\telegram\models\Usernames;
use onmotion\telegram\TelegramVars;
use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Request;
use Yii;

/**
 * User "/login" command
 */
class LoginCommand extends UserCommand
{
    /**#@+
     * {@inheritdoc}
     */
    protected $name = 'login';
    protected $description = '';
    protected $usage = '/login';
    protected $version = '1.0.0';
    
    public function __construct($telegram, $update = NULL)
    {
        $this->description = \Yii::t('tlgrm', 'Login to the support system');
        parent::__construct($telegram, $update);
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $message = $this->getMessage();
        $chat = $message->getChat();
        $username = $chat->getFirstName() . ' ' . $chat->getLastName() . ' (@' . $chat->getUsername() . ')';
        $chat_id = $chat->getId();
        $text = Yii::t('tlgrm', 'Enter passphrase:');
        $userId = $message->getFrom()->getId();
        $authChat = AuthorizedManagerChat::findOne($chat_id);
        if ($authChat) {
            $data = [
                'chat_id' => $chat_id,
                'text' => Yii::t('tlgrm', 'You are already logged in as ') . $username,
            ];
            return Request::sendMessage($data);
        } else {
            $dbUser = Actions::findOne($chat_id);
            if ($dbUser) {
                $dbUser->action = 'login';
            } else {
                $dbUser = new Actions();
                $dbUser->chat_id = $chat_id;
                $dbUser->action = 'login';
            }
            $dbUser->save();
            $data = [
                'chat_id' => $chat_id,
                'text' => $text,
            ];
            
            return Request::sendMessage($data);

        }
    }
}
