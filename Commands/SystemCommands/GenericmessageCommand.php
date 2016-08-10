<?php
/**
 * This file is part of the TelegramBot package.
 *
 * (c) Avtandil Kikabidze aka LONGMAN <akalongman@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Longman\TelegramBot\Commands\SystemCommands;

use onmotion\telegram\models\Actions;
use onmotion\telegram\models\AuthorizedChat;
use onmotion\telegram\models\AuthorizedManagerChat;
use onmotion\telegram\models\AuthorizedUsers;
use onmotion\telegram\models\Message;
use onmotion\telegram\models\Usernames;
use onmotion\telegram\TelegramVars;
use Longman\TelegramBot\Conversation;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Commands\SystemCommand;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Generic message command
 */
class GenericmessageCommand extends SystemCommand
{
    /**#@+
     * {@inheritdoc}
     */
    protected $name = 'Genericmessage';
    protected $description = 'Handle generic message';
    protected $version = '1.0.2';
    protected $need_mysql = false;
    /**#@-*/

    /**
     * Execution if MySQL is required but not available
     *
     * @return boolean
     */
    public function executeNoDb()
    {
        //Do nothing
        return Request::emptyResponse();
    }

    /**
     * Execute command
     *
     * @return boolean
     */
    public function execute()
    {

        //If a conversation is busy, execute the conversation command after handling the message
        $userId = $this->getMessage()->getFrom()->getId();
        $chat = $this->getMessage()->getChat();
        $chatId = $chat->getId();
        $username = $chat->getFirstName() . ' ' . $chat->getLastName() . ' (@' . $chat->getUsername() . ')';
        $conversation = new Conversation(
            $userId,
            $chatId
        );
        //Fetch conversation command if it exists and execute it
        if ($conversation->exists() && ($command = $conversation->getCommand())) {
            return $this->telegram->executeCommand($command, $this->update);
        }

        $authChat = AuthorizedManagerChat::find()->where(['chat_id' => $chatId])->andWhere(['not', ['client_chat_id' => null]])->one();
        if ($authChat){
       //менеджер уже ведет чат
                $message = new Message();
            $message->client_chat_id = $authChat->client_chat_id;
            $message->message = trim($this->getMessage()->getText(true));
            $message->direction = 1;
            $message->time = date("Y-m-d H:i:s");
            $message->save();
            return Request::emptyResponse();
        }

        $dbUser = Actions::findOne($chatId);
        $text = trim($this->getMessage()->getText(true));
        if ($dbUser && $dbUser->action == 'login') {
            if ($text == PASSPHRASE) {
                $_authChat = AuthorizedManagerChat::findOne($chatId);
                if ($_authChat == null){
                    $_authChat = new AuthorizedManagerChat();
                    $_authChat->chat_id = $chatId;
                    $_authChat->save();
                    $data = [
                        'chat_id' =>  $chatId,
                        'text'    =>  Yii::t('tlgrm', "Passphrase is correct, now you'll get the messages."),
                    ];
                    //связь пользователя с чатом
                    $dbUserneme = new Usernames();
                    $dbUserneme->chat_id = $chatId;
                    $dbUserneme->user_id = $userId;
                    $dbUserneme->username = $username;
                    $dbUserneme->save();
                }else{
                    $data = [
                        'chat_id' =>  $chatId,
                        'text'    =>  Yii::t('tlgrm', "You are already subscribed to receive messages."),
                    ];
                }
            }else{
                $data = [
                    'chat_id' =>  $chatId,
                    'text'    => Yii::t('tlgrm', 'Incorrect passphrase.'),
                ];
            }
            $dbUser->action = null;
            $dbUser->save();
        } else {
            $data = [
                'chat_id' => $chatId,
                'text' => Yii::t('tlgrm', 'Try to enter the command, such as /help'),
            ];
        }

        return Request::sendMessage($data);
        // return Request::emptyResponse();
    }
}
