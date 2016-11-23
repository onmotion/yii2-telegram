# **Telegram support Bot for Yii2**
[![Latest Stable Version](https://poser.pugx.org/onmotion/yii2-telegram/v/stable)](https://packagist.org/packages/onmotion/yii2-telegram) [![Total Downloads](https://poser.pugx.org/onmotion/yii2-telegram/downloads)](https://packagist.org/packages/onmotion/yii2-telegram) [![License](https://poser.pugx.org/onmotion/yii2-telegram/license)](https://packagist.org/packages/onmotion/yii2-telegram) [![Daily Downloads](https://poser.pugx.org/onmotion/yii2-telegram/d/daily)](https://packagist.org/packages/onmotion/yii2-telegram) [![Monthly Downloads](https://poser.pugx.org/onmotion/yii2-telegram/d/monthly)](https://packagist.org/packages/onmotion/yii2-telegram)

**Support chat for site based on Telegram bot**

The Bot logic based on [akalongman/php-telegram-bot](https://github.com/akalongman/php-telegram-bot), so you can read Instructions by longman how to register Telegram Bot and etc.

***Now only telegram webhook api support. You need SSL cert! Doesn't work on http!*** 

**Installation**
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Run


    composer require onmotion/yii2-telegram

 
 add to your web config:
  
     'modules' => [
	     //...
        'telegram' => [
            'class' => 'onmotion\telegram\Module',
            'API_KEY' => 'forexample241875489:AdfgdfFuVJdsKa1cycuxra36g4dfgt66',
            'BOT_NAME' => 'YourBotName_bot',
            'hook_url' => 'https://yourhost.com/telegram/default/hook', // must be https!
            'PASSPHRASE' => 'passphrase for login',
            // 'db' => 'db2', //db file name from config dir
	        // 'userCommandsPath' => '@app/modules/telegram/UserCommands',
	        // 'timeBeforeResetChatHandler' => 60
        ]
	    //more...
     ]
     
 and to console config:
 
     'bootstrap' => [   
     //other bootstrap components...
                    'telegram'],
     'modules' => [
             //...
         'telegram' => [
             'class' => 'onmotion\telegram\Module',
             'API_KEY' => 'forexample241875489:AdfgdfFuVJdsKa1cycuxra36g4dfgt66',
             'BOT_NAME' => 'YourBotName_bot',
         ]
     ],       

run migrations:

    php yii migrate --migrationPath=@vendor/onmotion/yii2-telegram/migrations #that add 4 tables in your DB


go to https://yourhost.com/telegram/default/set-webhook

Now you can place where you want

    echo \onmotion\telegram\Telegram::widget(); //that add chat button in the page

in bottom right corner you can see:

![chat button](https://github.com/onmotion/yii2-telegram/blob/wiki/_wiki/04.png?raw=true)

if you click it:

![client chat](https://github.com/onmotion/yii2-telegram/blob/wiki/_wiki/03.png?raw=true)

and server side:

![client chat](https://github.com/onmotion/yii2-telegram/blob/wiki/_wiki/02.png?raw=true)

If you want to limit the storage period of messages history, add to you crontab:

    #leave 5 days (if empty - default = 7)
    php yii telegram/messages/clean 5

Also you can use custom commands. To do this, you should copy UserCommands dir from /vendor/onmotion/yii2-telegram/Commands and add path to this in config, for example:

    'userCommandsPath' => '@app/modules/telegram/UserCommands'

**timeBeforeResetChatHandler** - the number of minutes before chat handler will be killed (if he forgot do /leavedialog). Never kill if 0 or not setted.