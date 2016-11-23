<?php
/**
 * @copyright Copyright &copy; Alexandr Kozhevnikov (onmotion)
 * @package yii2-telegram
 * Date: 02.08.2016
 */
namespace onmotion\telegram\models;

use Yii;

/**
 * This is the model class for table "authorized_chats".
 *
 * @property integer $chat_id
 * @property integer $client_chat_id
 * @property string $timestamp
 */
class AuthorizedManagerChat extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tlgrm_auth_mngr_chats';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        $db = \Yii::$app->controller->module->db;
        return Yii::$app->get($db);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['chat_id'], 'required'],
            [['chat_id'], 'integer'],
            [['client_chat_id'], 'string'],
            [['client_chat_id'], 'unique'],
            [['timestamp'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'chat_id' => 'Chat ID',
        ];
    }
}
