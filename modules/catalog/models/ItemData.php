<?php
namespace app\modules\catalog\models;

use Yii;
use app\behaviors\SluggableBehavior;
use app\behaviors\SeoBehavior;
use app\behaviors\SortableModel;
use app\models\Photo;

class ItemData extends \app\components\ActiveRecord
{

    public static function tableName()
    {
        return 'catalog_item_data';
    }
}