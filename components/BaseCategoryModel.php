<?php
namespace app\components;

use Yii;
use app\behaviors\CacheFlush;
use app\behaviors\ControlPositionModel;

/**
 * Base CategoryModel. Shared by categories
 * @package yii\easyii\components
 * @inheritdoc
 */
class BaseCategoryModel extends \app\components\ActiveRecord
{
		const STATUS_OFF= 0;
    const STATUS_ON = 1;
		private $_flatArray;
		private function _createFlatArray($data, $byId)
		{
				foreach($data as $item) {
					if($byId)
						$this->_flatArray[$item->id] = $item;
					else
						$this->_flatArray[] = $item;
					$children = $item->getChildren()->sortPos()->all();
					if($children) {
						$this->_createFlatArray($children, $byId);
					}
				}
				return $this->_flatArray;
		}
		
		protected function setDepth()
		{
				$depth = 0;
				$parent = $this->parent;
				while($parent) {
						++$depth;
						$parent = $parent->parent;
				}
				$this->depth = $depth;
		}
		
    public function behaviors()
    {
        return [
            'cacheflush' => [
                'class' => CacheFlush::className(),
                'key' => [static::tableName().'_tree']
            ],
            'controlPositionBehavior' => ControlPositionModel::className(),
        ];
    }
		
		public function getParent()
    {
        return $this->hasOne(static::className(), ['id' => 'parent_id']);
    }
		
		public function getChildren()
    {
        return $this->hasMany(static::className(), ['parent_id' => 'id']);
    }
		
		public static function tree()
		{
				$cache = Yii::$app->cache;
        $key = static::tableName().'_tree';
				
				$tree = $cache->get($key);
				if(!$tree){
					  $tree = static::generateTree();
            $cache->set($key, $tree, 3600);
        }
        return $tree;
				
		}
		public static function cats()
		{
				$cache = Yii::$app->cache;
        $key = static::tableName().'_cats';
				
				$tree = $cache->get($key);
				if(!$tree){
					  $tree = static::generateTree(true);
            $cache->set($key, $tree, 3600);
        }
        return $tree;
				
		}
		public static function generateTree($byId=false)
    {
			$data = static::find()->with('children')
														->where(['parent_id'=>0])
														->sortPos()
														->all();
			if($data)
				$data =  (new self)->_createFlatArray($data,$byId);
			return $data;
		}
		
		public function getParentInfo()
		{
				$parentInfo = [];
				$parentInfo['parentName'] = 'parent_id';
				$parentInfo['parentId'] = $this->parent_id;
				return $parentInfo;
		}

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if(!$insert && $this->hasAttribute('image') && $this->image != $this->oldAttributes['image'] && $this->oldAttributes['image']) {
                @unlink(Yii::getAlias('@webroot').$this->oldAttributes['image']);
            }
						$this->setDepth();
            return true;
        } else {
            return false;
        }
    }

    public function afterDelete()
    {
        parent::afterDelete();
				foreach($this->children as $child) {
					$child->delete();
				}
        if($this->hasAttribute('image') && $this->image) {
            @unlink(Yii::getAlias('@webroot') . $this->image);
        }
    }
}