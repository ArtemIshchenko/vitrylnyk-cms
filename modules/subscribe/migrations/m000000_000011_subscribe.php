<?php
use yii\db\Schema;

use app\modules\subscribe\models\Subscriber;
use app\modules\subscribe\models\History;

class m000000_000011_subscribe extends \yii\db\Migration
{
    const VERSION = 0.9;

    public $engine = 'ENGINE=MyISAM DEFAULT CHARSET=utf8';
    
    public function up()
    {
        //SUBSCRIBE MODULE
        $this->createTable(Subscriber::tableName(), [
            'id' => 'pk',
            'email' => Schema::TYPE_STRING . '(128) NOT NULL',
            'ip' => Schema::TYPE_STRING . '(16) NOT NULL',
            'time' => Schema::TYPE_INTEGER .  " DEFAULT '0'"
        ], $this->engine);
        $this->createIndex('email', Subscriber::tableName(), 'email', true);

        $this->createTable(History::tableName(), [
            'id' => 'pk',
            'subject' => Schema::TYPE_STRING . '(128) NOT NULL',
            'body' => Schema::TYPE_TEXT . ' NOT NULL',
            'sent' => Schema::TYPE_INTEGER .  " DEFAULT '0'",
            'time' => Schema::TYPE_INTEGER .  " DEFAULT '0'"
        ], $this->engine);
    }
		
    public function down()
    {
				$this->dropTable(Subscriber::tableName());
        $this->dropTable(History::tableName());
    }
}
