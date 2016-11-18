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
        //Do nothing, just for rewriting default Longman command
        return Request::emptyResponse();
    }
}
