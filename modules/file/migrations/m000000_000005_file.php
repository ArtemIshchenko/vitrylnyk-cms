<?php
use yii\db\Schema;

use app\modules\file\models\File;

class m000000_000005_file extends \yii\db\Migration
{
    const VERSION = 0.9;

    public $engine = 'ENGINE=MyISAM DEFAULT CHARSET=utf8';
    
    public function up()
    {
        //FILE MODULE
        $this->createTable(File::tableName(), [
            'id' => 'pk',
            'title' => Schema::TYPE_STRING . '(128) NOT NULL',
            'file' => Schema::TYPE_STRING . '(255) NOT NULL',
            'size' => Schema::TYPE_INTEGER .  ' NOT NULL',
            'slug' => Schema::TYPE_STRING . '(128) DEFAULT NULL',
            'downloads' => Schema::TYPE_INTEGER . " DEFAULT '0'",
            'time' => Schema::TYPE_INTEGER .  " DEFAULT '0'",
            'pos' => Schema::TYPE_INTEGER,
        ], $this->engine);
        $this->createIndex('slug', File::tableName(), 'slug', true);
    }

    public function down()
    {
        $this->dropTable(File::tableName());
    }
}
