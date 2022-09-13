<?php
use yii\db\Schema;

use app\modules\page\models\Page;

class m000000_000004_page extends \yii\db\Migration
{
    const VERSION = 0.9;

    public $engine = 'ENGINE=MyISAM DEFAULT CHARSET=utf8';
    
    public function up()
    {
        //PAGE MODULE
        $this->createTable(Page::tableName(), [
            'id' => 'pk',
            'title' => Schema::TYPE_STRING . '(128) NOT NULL',
            'text' => Schema::TYPE_TEXT . ' NOT NULL',
            'slug' => Schema::TYPE_STRING . '(128) DEFAULT NULL'
        ], $this->engine);
        $this->createIndex('slug', Page::tableName(), 'slug', true);
    }

    public function down()
    {
        $this->dropTable(Page::tableName());
    }
}
