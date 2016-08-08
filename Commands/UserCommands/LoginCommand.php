<?php
/**
 * This file is part of the TelegramBot package.
 *
 * (c) Avtandil Kikabidze aka LONGMAN <akalongman@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Longman\TelegramBot\Commands\UserCommands;

use onmotion\telegram\models\Actions;
use onmotion\telegram\models\AuthorizedManagerChat;
use onmotion\telegram\models\Usernames;
use onmotion\telegram\TelegramVars;
use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Request;
use Yii;

/**
 * User "/echo" command
 */
class LoginCommand extends UserCommand
{
    /**#@+
     * {@inheritdoc}
     */
    protected $name = 'login';
    protected $description = 'Залогиниться в системе для получения сообщений.';
    protected $usage = '/login';
    protected $version = '1.0.0';

    /**#@-*/

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $message = $this->getMessage();
        $chat = $message->getChat();
        $username = $chat->getFirstName() . ' ' . $chat->getLastName() . ' (@' . $chat->getUsername() . ')';
        $chat_id = $chat->getId();
        $text = 'Введите passphrase:';
        $userId = $message->getFrom()->getId();
        $authChat = AuthorizedManagerChat::findOne($chat_id);
        if ($authChat) {
            $data = [
                'chat_id' => $chat_id,
                'text' => 'Вы уже вошли в систему как ' . $username,
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
            //связь пользователя с чатом
            $dbUser = new Usernames();
            $dbUser->chat_id = $chat_id;
            $dbUser->user_id = $userId;
            $dbUser->username = $username;
            $dbUser->save();
            
            return Request::sendMessage($data);

        }
    }
}
