<?php
use yii\db\Schema;

use app\modules\article;

class m000000_000001_article extends \yii\db\Migration
{
    const VERSION = 0.9;

    public $engine = 'ENGINE=MyISAM DEFAULT CHARSET=utf8';
    
    public function up()
    {
 
        //ARTICLE MODULE
        $this->createTable(article\models\Category::tableName(), [
            'id' => 'pk',
						'parent_id' => Schema::TYPE_INTEGER . " DEFAULT '0'",
            'title' => Schema::TYPE_STRING . '(128) NOT NULL',
            'image' => Schema::TYPE_STRING . '(128) DEFAULT NULL',
            'pos' => Schema::TYPE_INTEGER,
            'slug' => Schema::TYPE_STRING . '(128) DEFAULT NULL',
            'depth' => Schema::TYPE_INTEGER,
            'status' => Schema::TYPE_BOOLEAN . " DEFAULT '1'"
        ], $this->engine);
        $this->createIndex('slug', article\models\Category::tableName(), 'slug', true);

        $this->createTable(article\models\Item::tableName(), [
            'id' => 'pk',
            'category_id' => Schema::TYPE_INTEGER,
            'title' => Schema::TYPE_STRING . '(128) NOT NULL',
            'image' => Schema::TYPE_STRING . '(128) DEFAULT NULL',
            'short' => Schema::TYPE_STRING . '(1024) DEFAULT NULL',
            'text' => 'MEDIUMTEXT NOT NULL',
            'slug' => Schema::TYPE_STRING . '(128) DEFAULT NULL',
            'time' => Schema::TYPE_INTEGER .  " DEFAULT '0'",
            'views' => Schema::TYPE_INTEGER . " DEFAULT '0'",
            'status' => Schema::TYPE_BOOLEAN . " DEFAULT '1'"
        ], $this->engine);
        $this->createIndex('slug', article\models\Item::tableName(), 'slug', true);
    }
		
    public function down()
    {
        $this->dropTable(article\models\Category::tableName());
        $this->dropTable(article\models\Item::tableName());
    }
}
