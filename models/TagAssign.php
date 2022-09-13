<?php
namespace app\models;

class TagAssign extends \app\components\ActiveRecord
{
    public static function tableName()
    {
        return 'tags_assign';
    }
}