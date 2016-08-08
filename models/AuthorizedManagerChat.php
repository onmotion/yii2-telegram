<?php

namespace onmotion\telegram\models;

use Yii;

/**
 * This is the model class for table "authorized_chats".
 *
 * @property integer $chat_id
 * @property integer $client_chat_id
 */
class AuthorizedManagerChat extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'authorized_mngr_chats';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db7');
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
