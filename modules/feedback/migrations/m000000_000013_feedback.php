<?php
use yii\db\Schema;

use app\modules\feedback\models\Feedback;

class m000000_000013_feedback extends \yii\db\Migration
{
    const VERSION = 0.9;

    public $engine = 'ENGINE=MyISAM DEFAULT CHARSET=utf8';
    
    public function up()
    {
        //FEEDBACK MODULE
        $this->createTable(Feedback::tableName(), [
            'id' => 'pk',
            'name' => Schema::TYPE_STRING . '(64) NOT NULL',
            'email' => Schema::TYPE_STRING . '(128) NOT NULL',
            'phone' => Schema::TYPE_STRING . '(64) DEFAULT NULL',
            'title' => Schema::TYPE_STRING . '(128) DEFAULT NULL',
            'text' => Schema::TYPE_TEXT . ' NOT NULL',
            'answer_subject' => Schema::TYPE_STRING . '(128) DEFAULT NULL',
            'answer_text' => Schema::TYPE_TEXT . ' DEFAULT NULL',
            'time' => Schema::TYPE_INTEGER .  " DEFAULT '0'",
            'ip' => Schema::TYPE_STRING . '(16) NOT NULL',
            'status' => Schema::TYPE_BOOLEAN . " DEFAULT '0'"
        ], $this->engine);
    }
		
    public function down()
    {
        $this->dropTable(Feedback::tableName());
    }
}
