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
use Yii;

/**
 * User "/leavedialog" command
 */
class LeavedialogCommand extends UserCommand
{
    /**#@+
     * {@inheritdoc}
     */
    protected $name = 'leavedialog';
    protected $description = '';
    protected $usage = '/leavedialog';
    protected $version = '1.0.0';
    /**#@-*/

    public function __construct($telegram, $update = NULL)
    {
        $this->description = Yii::t('tlgrm', 'End the currently active conversation and switch to standby mode.');
        parent::__construct($telegram, $update);
    }

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
            $data['text'] = Yii::t('tlgrm', 'You are not authorized!');
        }else {
            $currantChat = $authChat->client_chat_id;
            if ($currantChat) {
                $data['text'] = Yii::t('tlgrm', 'Completed conversation in chat ') . $currantChat;
                $authChat->client_chat_id = null;
                $authChat->save();
            } else {
                $data['text'] = Yii::t('tlgrm', 'You have no active conversations.');
            }
        }
        return Request::sendMessage($data);

    }
}
