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

use onmotion\telegram\models\AuthorizedManagerChat;
use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Request;

/**
 * User "/echo" command
 */
class Leave_dialogCommand extends UserCommand
{
    /**#@+
     * {@inheritdoc}
     */
    protected $name = 'leave_dialog';
    protected $description = 'Закончить текущий активный диалог и перейти в режим ожидания';
    protected $usage = '/leave_dialog';
    protected $version = '1.0.0';
    /**#@-*/

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $message = $this->getMessage();
        $chat_id = $message->getChat()->getId();

        $data = [
            'chat_id' => $chat_id,
        ];
        $authChat = AuthorizedManagerChat::findOne($chat_id);
        if (!$authChat){
            $data['text'] = 'Вы не авторизовались!';
        }else {
            $currantChat = $authChat->client_chat_id;
            if ($currantChat) {
                $data['text'] = 'Завершен диалог в чате ' . $currantChat;
                $authChat->client_chat_id = null;
                $authChat->save();
            } else {
                $data['text'] = 'У вас нет активных диалогов.';
            }
        }
        return Request::sendMessage($data);

    }
}
