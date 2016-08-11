<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace onmotion\telegram\commands;

use yii\console\Controller;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class MessagesController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionClean($keep = 7)
    {
        $db = \Yii::$app->db;
        $db->createCommand()->delete('tlgrm_messages', 'time < \'' . date("Y-m-d H:i:s", time() - (3600 * 24 * $keep)) . '\'')->execute();
    }
}
