<?php
namespace app\modules\article\models;

use app\modules\article\models\Item;

class Category extends \app\components\CategoryModel
{
	
    public static function tableName()
    {
        return 'article_category';
    }

    public function getItems()
    {
        return $this->hasMany(Item::className(), ['category_id' => 'id']);
    }
		
		/*public function getRelatedLists()
    {
        return $this->hasMany(RelatedList::className(), ['category_id' => 'id']);
    }*/

    public function afterDelete()
    {
        parent::afterDelete();

        foreach ($this->getItems()->all() as $article) {
            $article->delete();
        }
				/*foreach ($this->getRelatedLists()->all() as $list) {
            $list->delete();
        }*/
    }
}