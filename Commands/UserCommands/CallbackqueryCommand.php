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

use onmotion\telegram\models\AuthorizedManagerChat;
use onmotion\telegram\models\Usernames;
use Longman\TelegramBot\Commands\SystemCommand;
use Longman\TelegramBot\Request;
use Yii;

/**
 * Callback query command
 */
class CallbackqueryCommand extends SystemCommand
{
    /**#@+
     * {@inheritdoc}
     */
    protected $name = 'callbackquery';
    protected $description = 'Reply to callback query';
    protected $version = '1.0.0';
    /**#@-*/

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $update = $this->getUpdate();

        $callback_query = $update->getCallbackQuery();
        $chatId = $callback_query->getMessage()->getChat()->getId();
        $callback_query_id = $callback_query->getId();
        $callback_data = $callback_query->getData();

        $data['callback_query_id'] = $callback_query_id;
        $callbackDataArr = explode(' ', $callback_data);

        if ($callbackDataArr[0] == 'client_chat_id') {

            $data['show_alert'] = true;
            //Закрепляем чат за авторизованным менеджером
            $authChat = AuthorizedManagerChat::findOne(intval($chatId));
            $authChat->client_chat_id = $callbackDataArr[1];
            if ($authChat->validate() && $authChat->save()){
                $data['text'] = Yii::t('tlgrm', 'Start conversation with chat ') . $callbackDataArr[1];
                Request::answerCallbackQuery($data);
                unset($data['show_alert'], $data['callback_query_id']);
                $data['chat_id'] = $chatId;
                return Request::sendMessage($data);
            }else{
                try {
                    $authChat = AuthorizedManagerChat::find()->where(['client_chat_id' => $callbackDataArr[1]])->one();
                    $manager = Usernames::find()->where(['chat_id' => $authChat->chat_id])->one();
                    $data['text'] = Yii::t('tlgrm', 'Conversation already in progress in this chat. Responsible: ') . ($manager->username ? $manager->username : "not_found");
                } catch (\Exception $e){
                    $data['text'] = Yii::t('tlgrm', 'Seems conversation already in progress in this chat.');
                }
                    unset($data['show_alert'], $data['callback_query_id']);
                    $data['chat_id'] = $chatId;

                return Request::sendMessage($data);
            }
        } else {
            $data['text'] = Yii::t('tlgrm', 'Unknown command.');
            $data['show_alert'] = false;
            return Request::answerCallbackQuery($data);
        }

    }
}
