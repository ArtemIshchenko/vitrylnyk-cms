<?php
namespace app\modules\text\models;

use Yii;
use app\behaviors\CacheFlush;

class Text extends \app\components\ActiveRecord
{
    const CACHE_KEY = 'text';

    public static function tableName()
    {
        return 'texts';
    }

    public function rules()
    {
        return [
            ['text', 'required'],
            ['text', 'trim'],
            ['slug', 'match', 'pattern' => self::$SLUG_PATTERN, 'message' => Yii::t('app', 'Slug can contain only 0-9, a-z and "-" characters (max: 128).')],
            ['slug', 'default', 'value' => null],
            ['slug', 'unique']
        ];
    }

    public function attributeLabels()
    {
        return [
            'text' => Yii::t('app', 'Text'),
            'slug' => Yii::t('app', 'Slug'),
        ];
    }

    public function behaviors()
    {
        return [
            CacheFlush::className()
        ];
    }
}