<?php
namespace app\modules\catalog\models;

class Category extends \app\components\CategoryModel
{
    static $fieldTypes = [
        'string' => 'String',
        'text' => 'Text',
        'boolean' => 'Boolean',
        'select' => 'Select',
        'checkbox' => 'Checkbox'
    ];

    public static function tableName()
    {
        return 'catalog_categories';
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if($insert && ($parent = $this->parent)){
                $this->fields = $parent->fields;
            }

            if(!$this->fields || !is_array($this->fields)){
                $this->fields = [];
            }
            $this->fields = json_encode($this->fields);

            return true;
        } else {
            return false;
        }
    }

    public function afterSave($insert, $attributes)
    {
        parent::afterSave($insert, $attributes);
        $this->parseFields();
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->parseFields();
    }

    public function getItems()
    {
        return $this->hasMany(Item::className(), ['category_id' => 'id'])->sortDate();
    }

    public function afterDelete()
    {
        parent::afterDelete();

        foreach($this->items as $item){
            $item->delete();
        }
    }

    private function parseFields(){
        $this->fields = $this->fields !== '' ? json_decode($this->fields) : [];
    }
}