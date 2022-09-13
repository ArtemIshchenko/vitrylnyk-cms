<?php
use yii\db\Schema;

use app\modules\guestbook\models\Guestbook;

class m000000_000010_guestbook extends \yii\db\Migration
{
    const VERSION = 0.9;

    public $engine = 'ENGINE=MyISAM DEFAULT CHARSET=utf8';
    
    public function up()
    {
        //GUESTBOOK MODULE
        $this->createTable(Guestbook::tableName(), [
            'id' => 'pk',
            'name' => Schema::TYPE_STRING . '(128) NOT NULL',
            'title' => Schema::TYPE_STRING . '(128) DEFAULT NULL',
            'text' => Schema::TYPE_TEXT . ' NOT NULL',
            'answer' => Schema::TYPE_TEXT . ' DEFAULT NULL',
            'email' => Schema::TYPE_STRING . '(128) DEFAULT NULL',
            'time' => Schema::TYPE_INTEGER .  " DEFAULT '0'",
            'ip' => Schema::TYPE_STRING . '(16) NOT NULL',
            'new' => Schema::TYPE_BOOLEAN . " DEFAULT '0'",
            'status' => Schema::TYPE_BOOLEAN . " DEFAULT '0'"
        ], $this->engine);
    }
		
    public function down()
    {
        $this->dropTable(Guestbook::tableName());
    }
}
