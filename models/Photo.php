<?php
namespace app\models;

use Yii;
use app\behaviors\ControlPositionModel;

class Photo extends \app\components\ActiveRecord
{
    const PHOTO_MAX_WIDTH = 1900;
    const PHOTO_THUMB_WIDTH = 90;
    const PHOTO_THUMB_HEIGHT = 120;

    public static function tableName()
    {
        return 'photos';
    }

    public function rules()
    {
        return [
            [['class', 'item_id'], 'required'],
            ['item_id', 'integer'],
            ['image', 'image'],
            ['description', 'trim'],
						['pos', 'safe'],
        ];
    }

    public function behaviors()
    {
        return [
            ControlPositionModel::className()
        ];
    }
		
		public function getParentInfo()
		{
				$parentInfo['parentName'] = 'item_id';
				$parentInfo['parentId'] = $this->item_id;
				$parentInfo['class'] = $this->class;
				return $parentInfo;
		}
		
    public function afterDelete()
    {
        parent::afterDelete();

        @unlink(Yii::getAlias('@webroot').$this->image);
    }
}