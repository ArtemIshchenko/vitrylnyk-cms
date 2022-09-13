<?php
use yii\db\Schema;

use app\modules\menu;

class m000000_000021_menu extends \yii\db\Migration
{
    const VERSION = 0.9;

    public $engine = 'ENGINE=MyISAM DEFAULT CHARSET=utf8';
    
    public function up()
    {
        //MENU MODULE
        $this->createTable(menu\models\Item::tableName(), [
            'id' => 'pk',
						'parent_id' => Schema::TYPE_INTEGER . " DEFAULT '0'",
            'title' => Schema::TYPE_STRING . '(128) NOT NULL',
						'url' => Schema::TYPE_STRING . '(128) NOT NULL',
            'pos' => Schema::TYPE_INTEGER,
            'depth' => Schema::TYPE_INTEGER,
            'status' => Schema::TYPE_BOOLEAN . " DEFAULT '1'"
        ], $this->engine);
    }
		
    public function down()
    {
        $this->dropTable(menu\models\Item::tableName());
    }
}
