<?php
namespace app\behaviors;

use yii\db\ActiveRecord;

/**
 * Sortable behavior. Enables model to be sorted manually by admin
 * @package yii\easyii\behaviors
 */
class ControlPositionModel extends \yii\base\Behavior
{
		public $swap_id;
		
		protected function getOwnerClassName()
		{
				return get_class($this->owner);
		}
		
		protected function prev($pos)
		{
				$className = $this->ownerClassName;
				$query = $className::find()->where(['<', 'pos', $pos]);
				$query = $this->addExtraConditions($query);
				$prev = $query->orderBy(['pos'=>SORT_DESC])->limit(1)->one();
				return $prev;
		}
		
		protected function next($pos)
		{
				$className = $this->ownerClassName;
				$query = $className::find()->andWhere(['>', 'pos', $pos]);
				$query = $this->addExtraConditions($query);
				$next = $query->orderBy(['pos'=>SORT_ASC])->limit(1)->one();
				return $next;
		}
		
		protected function getMaxPos()
		{
				$className = $this->ownerClassName;
				$query = $className::find();
				$query = $this->addExtraConditions($query);
				$maxPos = (int)$query->max('pos');
				return $maxPos;
		}
		
		protected function addExtraConditions($query)
		{
			$parentInfo = $this->owner->getParentInfo();
				if($parentInfo) {
					$query->andWhere([$parentInfo['parentName']=>$parentInfo['parentId']]);
					if(isset($parentInfo['class']) && !empty($parentInfo['class']))
						$query->andWhere(['class'=>$parentInfo['class']]);
				}
				return $query;
		}
		
		public function setNextPos()
    {
        $maxPos = $this->getMaxPos();
				if($maxPos)
					$this->owner->pos = ++$maxPos;
				else
					$this->owner->pos = 1;
    }
			
		public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'setNextPos',
						ActiveRecord::EVENT_AFTER_DELETE => 'shiftPos',
        ];
    }

		public function shiftPos()
		{
				if(($next = $this->next($this->owner->pos)) && ($maxPos = $this->getMaxPos())) {
					for($i=$next->pos; $i<=$maxPos; $i++) {
						if($next) {
							$next->pos = $i-1;
							$next->save(false);
							$next = $this->next($next->pos);
						}
					}
				}
		}
		
		public function up()
		{
				if($prev = $this->prev($this->owner->pos)) {
					$pos = $this->owner->pos;
					$this->owner->pos = $prev->pos;
					$this->swap_id = $prev->id;
					$prev->pos = $pos;
					return $prev->save(false) && $this->owner->save(false);
				}
				return false;
		}
		
		public function down()
		{
				if($next = $this->next($this->owner->pos)) {
					$pos = $this->owner->pos;
					$this->owner->pos = $next->pos;
					$this->swap_id = $next->id;
					$next->pos = $pos;
					return $next->save(false) && $this->owner->save(false);
				}
				return false;
		}
}