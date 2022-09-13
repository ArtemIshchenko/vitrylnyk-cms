<?php
use yii\db\Schema;

use app\modules\text\models\Text;

class m000000_000009_text extends \yii\db\Migration
{
    const VERSION = 0.9;

    public $engine = 'ENGINE=MyISAM DEFAULT CHARSET=utf8';
    
    public function up()
    {
        //TEXT MODULE
        $this->createTable(Text::tableName(), [
            'id' => 'pk',
            'text' => Schema::TYPE_TEXT . ' NOT NULL',
            'slug' => Schema::TYPE_STRING . '(128) DEFAULT NULL'
        ], $this->engine);
        $this->createIndex('slug', Text::tableName(), 'slug', true);
    }
		
    public function down()
    {
        $this->dropTable(Text::tableName());
    }
}
