<?php
use yii\db\Schema;

use app\modules\faq\models\Faq;

class m000000_000014_faq extends \yii\db\Migration
{
    const VERSION = 0.9;

    public $engine = 'ENGINE=MyISAM DEFAULT CHARSET=utf8';
    
    public function up()
    {
        //FAQ MODULE
        $this->createTable(Faq::tableName(), [
            'id' => 'pk',
            'question' => Schema::TYPE_TEXT . ' NOT NULL',
            'answer' => Schema::TYPE_TEXT . ' NOT NULL',
            'pos' => Schema::TYPE_INTEGER,
            'status' => Schema::TYPE_BOOLEAN . " DEFAULT '1'"
        ], $this->engine);
    }
		
    public function down()
    {

    }
}
