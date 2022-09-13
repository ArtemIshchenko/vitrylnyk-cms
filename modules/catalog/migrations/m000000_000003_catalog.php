<?php
use yii\db\Schema;

use app\modules\catalog;

class m000000_000003_catalog extends \yii\db\Migration
{
    const VERSION = 0.9;

    public $engine = 'ENGINE=MyISAM DEFAULT CHARSET=utf8';
    
    public function up()
    {
 
         //CATALOG MODULE
        $this->createTable(catalog\models\Category::tableName(), [
            'id' => 'pk',
						'parent_id' => Schema::TYPE_INTEGER . " DEFAULT '0'",
            'title' => Schema::TYPE_STRING . '(128) NOT NULL',
            'image' => Schema::TYPE_STRING . '(128) DEFAULT NULL',
            'fields' => Schema::TYPE_TEXT . ' NOT NULL',
            'slug' => Schema::TYPE_STRING . '(128) DEFAULT NULL',
            'depth' => Schema::TYPE_INTEGER,
            'pos' => Schema::TYPE_INTEGER,
            'status' => Schema::TYPE_BOOLEAN . " DEFAULT '1'"
        ], $this->engine);
        $this->createIndex('slug', catalog\models\Category::tableName(), 'slug', true);

        $this->createTable(catalog\models\Item::tableName(), [
            'id' => 'pk',
            'category_id' => Schema::TYPE_INTEGER,
            'title' => Schema::TYPE_STRING . '(128) NOT NULL',
            'description' => Schema::TYPE_TEXT . ' DEFAULT NULL',
            'available' => Schema::TYPE_INTEGER . " DEFAULT '1'",
            'price' => Schema::TYPE_FLOAT . " DEFAULT '0'",
            'discount' => Schema::TYPE_INTEGER . " DEFAULT '0'",
            'data' => Schema::TYPE_TEXT . ' NOT NULL',
            'image' => Schema::TYPE_STRING . '(128) DEFAULT NULL',
            'slug' => Schema::TYPE_STRING . '(128) DEFAULT NULL',
            'time' => Schema::TYPE_INTEGER .  " DEFAULT '0'",
            'status' => Schema::TYPE_BOOLEAN . " DEFAULT '1'"
        ], $this->engine);
        $this->createIndex('slug', catalog\models\Item::tableName(), 'slug', true);

        $this->createTable(catalog\models\ItemData::tableName(), [
            'id' => 'pk',
            'item_id' => Schema::TYPE_INTEGER,
            'name' => Schema::TYPE_STRING . '(128) NOT NULL',
            'value' => Schema::TYPE_STRING . '(1024) DEFAULT NULL',
        ], $this->engine);
        $this->createIndex('item_id_name', catalog\models\ItemData::tableName(), ['item_id', 'name']);
        $this->createIndex('value', catalog\models\ItemData::tableName(), 'value(300)');
    }

    public function down()
    {
        $this->dropTable(catalog\models\Category::tableName());
        $this->dropTable(catalog\models\Item::tableName());
				$this->dropTable(catalog\models\ItemData::tableName());
    }
}
