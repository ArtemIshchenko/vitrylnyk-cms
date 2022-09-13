<?php
namespace app\modules\file\models;

use Yii;
use app\behaviors\SluggableBehavior;
use app\behaviors\SeoBehavior;
use app\behaviors\ControlPositionModel;

class File extends \app\components\ActiveRecord
{
    public static function tableName()
    {
        return 'files';
    }

    public function rules()
    {
        return [
            ['file', 'file'],
            ['title', 'required'],
            ['title', 'string', 'max' => 128],
            ['title', 'trim'],
            ['slug', 'match', 'pattern' => self::$SLUG_PATTERN, 'message' => Yii::t('app', 'Slug can contain only 0-9, a-z and "-" characters (max: 128).')],
            ['slug', 'default', 'value' => null],
            [['downloads', 'size'], 'integer'],
            ['time', 'default', 'value' => time()]
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => Yii::t('app', 'Title'),
            'file' => Yii::t('app', 'File'),
            'slug' => Yii::t('app', 'Slug')
        ];
    }

    public function behaviors()
    {
        return [
            ControlPositionModel::className(),
            'seoBehavior' => SeoBehavior::className(),
            'sluggable' => [
                'class' => SluggableBehavior::className(),
                'attribute' => 'title',
                'ensureUnique' => true
            ]
        ];
    }
		
		public function getParentInfo()
		{
				return false;
		}

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if(!$insert && $this->file !== $this->oldAttributes['file']){
                @unlink(Yii::getAlias('@webroot').$this->oldAttributes['file']);
            }
            return true;
        } else {
            return false;
        }
    }

    public function afterDelete()
    {
        parent::afterDelete();

        @unlink(Yii::getAlias('@webroot').$this->file);
    }
}