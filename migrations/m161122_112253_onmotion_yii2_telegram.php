<?php
/**
 * @copyright Copyright &copy; Alexandr Kozhevnikov (onmotion)
 * @package yii2-telegram
 * Date: 02.08.2016
 */
use yii\db\Migration;

class m161122_112253_onmotion_yii2_telegram extends Migration
{
    
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->addColumn('tlgrm_actions', 'param', $this->string(62));
        $this->addColumn('tlgrm_auth_mngr_chats', 'timestamp', $this->timestamp());
    }

    public function safeDown()
    {
        try {
            $this->dropColumn('tlgrm_actions', 'param');
            $this->dropColumn('tlgrm_auth_mngr_chats', 'timestamp');
        } catch (Exception $e){
            var_dump($e->getMessage());
            return false;
        }

        return "m160808_112253_onmotion_yii2_telegram was reverted.\n";
    }
    
}
