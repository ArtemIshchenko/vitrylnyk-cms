<?php
use yii\db\Schema;

use app\modules\gallery;

class m000000_000012_gallery extends \yii\db\Migration
{
    const VERSION = 0.9;

    public $engine = 'ENGINE=MyISAM DEFAULT CHARSET=utf8';
    
    public function up()
    {
         //GALLERY MODULE
				$this->createTable(gallery\models\Category::tableName(), [
            'id' => 'pk',
						'parent_id' => Schema::TYPE_INTEGER . " DEFAULT '0'",
            'title' => Schema::TYPE_STRING . '(128) NOT NULL',
            'image' => Schema::TYPE_STRING . '(128) DEFAULT NULL',
            'slug' => Schema::TYPE_STRING . '(128) DEFAULT NULL',
            'depth' => Schema::TYPE_INTEGER,
            'pos' => Schema::TYPE_INTEGER,
            'status' => Schema::TYPE_BOOLEAN . " DEFAULT '1'"
        ], $this->engine);
        $this->createIndex('slug', gallery\models\Category::tableName(), 'slug', true);
    }
		
    public function down()
    {
        $this->dropTable(gallery\models\Category::tableName());
    }
}
