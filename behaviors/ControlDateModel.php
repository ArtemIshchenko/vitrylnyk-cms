<?php
namespace app\behaviors;

use yii\db\ActiveRecord;

/**
 * Sortable behavior. Enables model to be sorted manually by admin
 * @package yii\easyii\behaviors
 */
class ControlDateModel extends \yii\base\Behavior
{
		public $swap_id;
		protected function getOwnerClassName()
		{
				return get_class($this->owner);
		}
		
		public function up()
		{
				$className = $this->ownerClassName;
				$query = $className::find()->where('time<'.$this->owner->time)->orderBy('time DESC')->limit(1);
				$parentInfo = $this->owner->getParentInfo();
					if($parentInfo)
						$query->andWhere($parentInfo['parentName'].'='.$parentInfo['parentId']);
				if($modelSwap = $query->one()) {
					$swapTime = $modelSwap->time;
					$modelSwap->time = $this->owner->time;
					$this->owner->time = $swapTime;
					$this->swap_id = $modelSwap->id;
					return $modelSwap->update(false) && $this->owner->save(false);
				}
				return false;
		}
		public function down()
		{
				$className = $this->ownerClassName;
				$query = $className::find()->where('time>'.$this->owner->time)->orderBy('time ASC')->limit(1);
				$parentInfo = $this->owner->getParentInfo();
					if($parentInfo)
						$query->andWhere($parentInfo['parentName'].'='.$parentInfo['parentId']);
				if($modelSwap = $query->one()) {
					$swapTime = $modelSwap->time;
					$modelSwap->time = $this->owner->time;
					$this->owner->time = $swapTime;
					$this->swap_id = $modelSwap->id;
					return $modelSwap->update(false) && $this->owner->save(false);
				}
				return false;
		}
}