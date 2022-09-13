<?php
namespace app\modules\subscribe\models;

use Yii;

class History extends \app\components\ActiveRecord
{
    public static function tableName()
    {
        return 'subscribe_history';
    }

    public function rules()
    {
        return [
            [['subject', 'body'], 'required'],
            ['subject', 'trim'],
            ['sent', 'number', 'integerOnly' => true],
            ['time', 'default', 'value' => time()],
        ];
    }

    public function attributeLabels()
    {
        return [
            'subject' => Yii::t('subscribe', 'Тема'),
            'body' => Yii::t('subscribe', 'Зміст'),
        ];
    }
}