<?php
namespace app\modules\gallery\models;

use app\models\Photo;

class Category extends \app\components\CategoryModel
{
    public static function tableName()
    {
        return 'gallery_categories';
    }

    public function getPhotos()
    {
        return $this->hasMany(Photo::className(), ['item_id' => 'id'])->where(['class' => self::className()])->sortPos();
    }

    public function afterDelete()
    {
        parent::afterDelete();

        foreach($this->getPhotos()->all() as $photo){
            $photo->delete();
        }
    }
}