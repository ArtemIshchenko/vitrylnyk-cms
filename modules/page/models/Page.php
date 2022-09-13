<?php
namespace app\modules\page\models;

use Yii;
use app\behaviors\SeoBehavior;

class Page extends \app\components\ActiveRecord
{
    public static function tableName()
    {
        return 'pages';
    }

    public function rules()
    {
        return [
            ['title', 'required'],
            [['title', 'text'], 'trim'],
            ['title', 'string', 'max' => 128],
            ['slug', 'match', 'pattern' => self::$SLUG_PATTERN, 'message' => Yii::t('app', 'Slug can contain only 0-9, a-z and "-" characters (max: 128).')],
            ['slug', 'default', 'value' => null],
            ['slug', 'unique'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => Yii::t('app', 'Title'),
            'text' => Yii::t('app', 'Text'),
            'slug' => Yii::t('app', 'Slug'),
        ];
    }

    public function behaviors()
    {
        return [
            'seoBehavior' => SeoBehavior::className(),
        ];
    }
}