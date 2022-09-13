<?php
use yii\db\Schema;
use app\models;
use app\modules\admin;

//use app\modules\faq\models\Faq;
//use app\modules\feedback\models\Feedback;
//use app\modules\gallery;

class m000000_000002_install extends \yii\db\Migration
{
    const VERSION = 0.9;

    public $engine = 'ENGINE=MyISAM DEFAULT CHARSET=utf8';
    
    public function up()
    {
        //ADMINS
        $this->createTable(admin\models\Admin::tableName(), [
            'id' => 'pk',
            'username' => Schema::TYPE_STRING . '(32) NOT NULL',
            'password' => Schema::TYPE_STRING . '(64) NOT NULL',
            'auth_key' => Schema::TYPE_STRING . '(128) NOT NULL',
            'access_token' => Schema::TYPE_STRING . '(128) DEFAULT NULL'
        ], $this->engine);
        $this->createIndex('access_token', admin\models\Admin::tableName(), 'access_token', true);

        //LOGINFORM
        $this->createTable(admin\models\LoginForm::tableName(), [
            'id' => 'pk',
            'username' => Schema::TYPE_STRING . '(128) NOT NULL',
            'password' => Schema::TYPE_STRING . '(128) NOT NULL',
            'ip' => Schema::TYPE_STRING . '(16) NOT NULL',
            'user_agent' => Schema::TYPE_STRING . '(1024) NOT NULL',
            'time' => Schema::TYPE_INTEGER . " DEFAULT '0'",
            'success' => Schema::TYPE_BOOLEAN . " DEFAULT '0'"
        ], $this->engine);

        //MODULES
        $this->createTable(admin\models\Module::tableName(), [
            'id' => 'pk',
            'name' => Schema::TYPE_STRING . '(64) NOT NULL',
            'class' => Schema::TYPE_STRING . '(128) NOT NULL',
            'title' => Schema::TYPE_STRING . '(128) NOT NULL',
            'icon' => Schema::TYPE_STRING . '(32) NOT NULL',
            'settings' => Schema::TYPE_TEXT . ' NOT NULL',
            'notice' => Schema::TYPE_INTEGER . " DEFAULT '0'",
            'pos' => Schema::TYPE_INTEGER,
            'status' => Schema::TYPE_BOOLEAN . " DEFAULT '0'"
        ], $this->engine);
        $this->createIndex('name', admin\models\Module::tableName(), 'name', true);

        //PHOTOS
        $this->createTable(models\Photo::tableName(), [
            'id' => 'pk',
            'class' => Schema::TYPE_STRING . '(128) NOT NULL',
            'item_id' => Schema::TYPE_INTEGER . " NOT NULL",
            'image' => Schema::TYPE_STRING . '(128) NOT NULL',
            'description' => Schema::TYPE_STRING . '(1024) NOT NULL',
            'pos' => Schema::TYPE_INTEGER . " NOT NULL",
        ], $this->engine);
        $this->createIndex('model_item', models\Photo::tableName(), ['class', 'item_id']);

        //SEOTEXT
        $this->createTable(models\SeoText::tableName(), [
            'id' => 'pk',
            'class' => Schema::TYPE_STRING . '(128) NOT NULL',
            'item_id' => Schema::TYPE_INTEGER . " NOT NULL",
            'h1' => Schema::TYPE_STRING . '(128) DEFAULT NULL',
            'title' => Schema::TYPE_STRING . '(128) DEFAULT NULL',
            'keywords' => Schema::TYPE_STRING . '(128) DEFAULT NULL',
            'description' => Schema::TYPE_STRING . '(128) DEFAULT NULL',
        ], $this->engine);
        $this->createIndex('model_item', models\SeoText::tableName(), ['class', 'item_id'], true);

        //SETTINGS
        $this->createTable(admin\models\Setting::tableName(), [
            'id' => 'pk',
            'name' => Schema::TYPE_STRING . '(64) NOT NULL',
            'title' => Schema::TYPE_STRING . '(128) NULL',
            'value' => Schema::TYPE_STRING . '(1024) NOT NULL',
            'visibility' => Schema::TYPE_BOOLEAN . " DEFAULT '0'",
        ], $this->engine);
        $this->createIndex('name', admin\models\Setting::tableName(), 'name', true);
				
				 //STATISTIC
        $this->createTable(models\Counter::tableName(), [
            'id' => 'pk',
            'url' => Schema::TYPE_STRING . '(128) NOT NULL',
            'title' => Schema::TYPE_STRING . '(128) NULL',
            'count' => Schema::TYPE_INTEGER . " NOT NULL",
						'last_status' => Schema::TYPE_STRING . '(32) NOT NULL',
						'last_time' => Schema::TYPE_INTEGER .  " DEFAULT '0'",
        ], $this->engine);

        //FEEDBACK MODULE
        /*$this->createTable(Feedback::tableName(), [
            'id' => 'pk',
            'name' => Schema::TYPE_STRING . '(64) NOT NULL',
            'email' => Schema::TYPE_STRING . '(128) NOT NULL',
            'phone' => Schema::TYPE_STRING . '(64) DEFAULT NULL',
            'title' => Schema::TYPE_STRING . '(128) DEFAULT NULL',
            'text' => Schema::TYPE_TEXT . ' NOT NULL',
            'answer_subject' => Schema::TYPE_STRING . '(128) DEFAULT NULL',
            'answer_text' => Schema::TYPE_TEXT . ' DEFAULT NULL',
            'time' => Schema::TYPE_INTEGER .  " DEFAULT '0'",
            'ip' => Schema::TYPE_STRING . '(16) NOT NULL',
            'status' => Schema::TYPE_BOOLEAN . " DEFAULT '0'"
        ], $this->engine);*/

        //GALLERY MODULE
        /*$this->createTable(gallery\models\Category::tableName(), [
            'id' => 'pk',
            'title' => Schema::TYPE_STRING . '(128) NOT NULL',
            'image' => Schema::TYPE_STRING . '(128) DEFAULT NULL',
            'slug' => Schema::TYPE_STRING . '(128) DEFAULT NULL',
            'tree' => Schema::TYPE_INTEGER,
            'lft' => Schema::TYPE_INTEGER,
            'rgt' => Schema::TYPE_INTEGER,
            'depth' => Schema::TYPE_INTEGER,
            'order_num' => Schema::TYPE_INTEGER,
            'status' => Schema::TYPE_BOOLEAN . " DEFAULT '1'"
        ], $this->engine);
        $this->createIndex('slug', gallery\models\Category::tableName(), 'slug', true);*/

        //FAQ MODULE
        /*$this->createTable(Faq::tableName(), [
            'id' => 'pk',
            'question' => Schema::TYPE_TEXT . ' NOT NULL',
            'answer' => Schema::TYPE_TEXT . ' NOT NULL',
            'order_num' => Schema::TYPE_INTEGER,
            'status' => Schema::TYPE_BOOLEAN . " DEFAULT '1'"
        ], $this->engine);*/

        //Tags
        $this->createTable(models\Tag::tableName(), [
            'id' => 'pk',
            'name' => Schema::TYPE_STRING . '(128) NOT NULL',
            'frequency' => Schema::TYPE_INTEGER . " DEFAULT '0'"
        ], $this->engine);
        $this->createIndex('name', models\Tag::tableName(), 'name', true);

        $this->createTable(models\TagAssign::tableName(), [
            'class' => Schema::TYPE_STRING . '(128) NOT NULL',
            'item_id' => Schema::TYPE_INTEGER . " NOT NULL",
            'tag_id' => Schema::TYPE_INTEGER . " NOT NULL",
        ], $this->engine);
        $this->createIndex('class', models\TagAssign::tableName(), 'class');
        $this->createIndex('item_tag', models\TagAssign::tableName(), ['item_id', 'tag_id']);

        //INSERT VERSION
        /*$this->delete(models\Setting::tableName(), ['name' => 'easyii_version']);
        $this->insert(models\Setting::tableName(), [
            'name' => 'version',
            'value' => self::VERSION,
            'title' => 'CMS version',
            'visibility' => models\Setting::VISIBLE_NONE
        ]);*/
    }

    public function down()
    {
        $this->dropTable(admin\models\Admin::tableName());
        $this->dropTable(admin\models\LoginForm::tableName());
        $this->dropTable(admin\models\Module::tableName());
        $this->dropTable(models\Photo::tableName());
        $this->dropTable(admin\models\Setting::tableName());
				$this->dropTable(admin\models\Counter::tableName());
        //$this->dropTable(Feedback::tableName());
        //$this->dropTable(gallery\models\Category::tableName());
    }
}
