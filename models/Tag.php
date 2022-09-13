<?php
namespace app\models;

class Tag extends \app\components\ActiveRecord
{
    public static function tableName()
    {
        return 'tags';
    }

    public function rules()
    {
        return [
            ['name', 'required'],
            ['frequency', 'integer'],
            ['name', 'string', 'max' => 64],
        ];
    }
}