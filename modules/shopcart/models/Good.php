<?php
namespace app\modules\shopcart\models;

use app\modules\catalog\models\Item;
use Yii;
use app\validators\EscapeValidator;

class Good extends \app\components\ActiveRecord
{
    public static function tableName()
    {
        return 'shopcart_goods';
    }

    public function rules()
    {
        return [
            [['order_id', 'item_id'], 'required'],
            [['order_id', 'item_id', 'count'], 'integer', 'min' => 1],
            ['price', 'number', 'min' => 0.1],
            ['options', 'trim'],
            ['options', 'string', 'max' => 255],
            ['options', EscapeValidator::className()],
            ['count', 'default', 'value' => 1],
            ['discount', 'default', 'value' => 0],
        ];
    }

    public function attributeLabels()
    {
        return [];
    }

    public function getItem()
    {
        return $this->hasOne(Item::className(), ['id' => 'item_id']);
    }

    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            return true;
        } else {
            return false;
        }
    }

    public function afterDelete()
    {
        parent::afterDelete();

    }
}