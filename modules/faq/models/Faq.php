<?php
namespace app\modules\faq\models;

use Yii;
use app\behaviors\CacheFlush;
use app\behaviors\ControlPositionModel;

class Faq extends \app\components\ActiveRecord
{
    const STATUS_OFF = 0;
    const STATUS_ON = 1;

    const CACHE_KEY = 'faq';

    public static function tableName()
    {
        return 'faq';
    }

    public function rules()
    {
        return [
            [['question','answer'], 'required'],
            [['question', 'answer'], 'trim'],
            ['status', 'integer'],
            ['status', 'default', 'value' => self::STATUS_ON],
        ];
    }

    public function attributeLabels()
    {
        return [
            'question' => Yii::t('faq', 'Питання'),
            'answer' => Yii::t('faq', 'Відповідь'),
        ];
    }

    public function behaviors()
    {
        return [
            CacheFlush::className(),
            ControlPositionModel::className()
        ];
    }
		public function getParentInfo()
		{
				return false;
		}
}