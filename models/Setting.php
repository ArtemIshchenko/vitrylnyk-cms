<?php
namespace app\models;

use Yii;

use app\helpers\Data;
use app\behaviors\CacheFlush;

class Setting extends \app\components\ActiveRecord
{
    const VISIBLE_NONE = 0;
    const VISIBLE_ROOT = 1;
    const VISIBLE_ALL = 2;

    const CACHE_KEY = 'setting';

    static $_data;

    public static function tableName()
    {
        return 'setting';
    }

    public function rules()
    {
        return [
            [['name', 'title', 'value'], 'required'],
            [['name', 'title', 'value'], 'trim'],
            ['name',  'match', 'pattern' => '/^[a-zA-Z][\w_-]*$/'],
            ['name', 'unique'],
            ['visibility', 'number', 'integerOnly' => true]
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'Name'),
            'title' => Yii::t('app', 'Title'),
            'value' => Yii::t('app', 'Value'),
            'visibility' => Yii::t('app', 'Only for developer')
        ];
    }

    public function behaviors()
    {
        return [
            CacheFlush::className()
        ];
    }

    public static function get($name)
    {
        if(!self::$_data){
            self::$_data =  Data::cache(self::CACHE_KEY, 3600, function(){
                $result = [];
                try {
                    foreach (self::find()->all() as $setting) {
                        $result[$setting->name] = $setting->value;
                    }
                }catch(\yii\db\Exception $e){}
								return $result;
            });
        }
        return isset(self::$_data[$name]) ? self::$_data[$name] : null;
    }

    public static function set($name, $value)
    {
        if(self::get($name)){
            $setting = Setting::find()->where(['name' => $name])->one();
            $setting->value = $value;
        } else {
            $setting = new Setting([
                'name' => $name,
                'value' => $value,
                'title' => $name,
                'visibility' => self::VISIBLE_NONE
            ]);
        }
        $setting->save();
    }
}