<?php
use yii\db\Schema;

use app\modules\shopcart;

class m000000_000006_shopcart extends \yii\db\Migration
{
    const VERSION = 0.9;

    public $engine = 'ENGINE=MyISAM DEFAULT CHARSET=utf8';
    
    public function up()
    {
        //SHOPCART MODULE
        $this->createTable(shopcart\models\Order::tableName(), [
            'id' => 'pk',
            'name' => Schema::TYPE_STRING . '(64) NOT NULL',
            'address' => Schema::TYPE_STRING . '(255) NOT NULL',
            'phone' => Schema::TYPE_STRING . '(64) NOT NULL',
            'email' => Schema::TYPE_STRING . '(128) NOT NULL',
            'comment' => Schema::TYPE_STRING . '(1024) NOT NULL',
            'remark' => Schema::TYPE_STRING . '(1024) NOT NULL',
            'access_token' => Schema::TYPE_STRING . '(32) NOT NULL',
            'ip' => Schema::TYPE_STRING . '(16) NOT NULL',
            'time' => Schema::TYPE_INTEGER .  " DEFAULT '0'",
            'new' => Schema::TYPE_BOOLEAN . " DEFAULT '0'",
            'status' => Schema::TYPE_BOOLEAN . " DEFAULT '0'"
        ], $this->engine);

        $this->createTable(shopcart\models\Good::tableName(), [
            'id' => 'pk',
            'order_id' => Schema::TYPE_INTEGER,
            'item_id' => Schema::TYPE_INTEGER,
            'count' => Schema::TYPE_INTEGER,
            'options' => Schema::TYPE_STRING . '(255) NOT NULL',
            'price' => Schema::TYPE_FLOAT . " DEFAULT '0'",
            'discount' => Schema::TYPE_INTEGER . " DEFAULT '0'",
        ], $this->engine);
    }

    public function down()
    {
    
    }
}
