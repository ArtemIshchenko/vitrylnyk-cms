<?php
namespace app\modules\carousel\models;

use Yii;
use app\behaviors\CacheFlush;
use app\behaviors\ControlPositionModel;

class Carousel extends \app\components\ActiveRecord
{
    const STATUS_OFF = 0;
    const STATUS_ON = 1;
    const CACHE_KEY = 'carousel';

    public static function tableName()
    {
        return 'carousel';
    }

    public function rules()
    {
        return [
            ['image', 'image'],
            [['title', 'text', 'link'], 'trim'],
            [['status'], 'integer'],
						['pos', 'safe'],
            ['status', 'default', 'value' => self::STATUS_ON],
        ];
    }

    public function attributeLabels()
    {
        return [
            'image' => Yii::t('app', 'Image'),
            'link' =>  Yii::t('app', 'Link'),
            'title' => Yii::t('app', 'Title'),
            'text' => Yii::t('app', 'Text'),
        ];
    }

    public function behaviors()
    {
        return [
            CacheFlush::className(),
            ControlPositionModel::className(),
        ];
    }
		
		public function getParentInfo()
		{
				return false;
		}

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if(!$insert && $this->image != $this->oldAttributes['image'] && $this->oldAttributes['image']){
                @unlink(Yii::getAlias('@webroot').$this->oldAttributes['image']);
            }
            return true;
        } else {
            return false;
        }
    }

    public function afterDelete()
    {
        parent::afterDelete();
				
				if($this->image){
					@unlink(Yii::getAlias('@webroot').$this->image);
				}
    }
}