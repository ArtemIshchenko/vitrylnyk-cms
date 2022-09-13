<?php
use yii\db\Schema;

use app\modules\carousel\models\Carousel;

class m000000_000008_carusel extends \yii\db\Migration
{
    const VERSION = 0.9;

    public $engine = 'ENGINE=MyISAM DEFAULT CHARSET=utf8';
    
    public function up()
    {
        //CAROUSEL MODULE
        $this->createTable(Carousel::tableName(), [
            'id' => 'pk',
            'image' => Schema::TYPE_STRING . '(128) NOT NULL',
            'link' => Schema::TYPE_STRING . '(255) NOT NULL',
            'title' => Schema::TYPE_STRING . '(128) DEFAULT NULL',
            'text' => Schema::TYPE_TEXT . ' DEFAULT NULL',
            'pos' => Schema::TYPE_INTEGER,
            'status' => Schema::TYPE_BOOLEAN . " DEFAULT '1'"
        ], $this->engine);
    }
		
    public function down()
    {
        $this->dropTable(Carousel::tableName());
    }
}
