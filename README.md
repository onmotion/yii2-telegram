# **Telegram support Bot for Yii2**
**Support chat for site based on Telegram bot**

The Bot logic based on [akalongman/php-telegram-bot](https://github.com/akalongman/php-telegram-bot), so you can read Instructions by longman how to register Telegram Bot and etc.

**Installation**
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run


    composer require onmotion/yii2-telegram

 

 add to your config:
  
     'modules' => [
	     //...
        'telegram' => [
            'class' => 'onmotion\telegram\Module',
            'API_KEY' => 'forexample241875489:AdfgdfFuVJdsKa1cycuxra36g4dfgt66',
            'BOT_NAME' => 'YourBotName_bot',
            'hook_url' => 'https://yourhost.com/telegram/default/hook', // must be https!
            'PASSPHRASE' => 'passphrase for login'
        ]
	    //more...
     ]

run migrations:

    php yii migrate --migrationPath=@vendor/onmotion/yii2-telegram/migrations #that add 4 tables in your DB


go to https://yourhost.com/telegram/default/set-webhook

Now you can place where you want echo 

    \onmotion\telegram\Telegram::widget(); //that add chat button in the page