<?php
namespace app\behaviors;

use Yii;

/**
 * Status behavior. Adds statuses to models
 * @package yii\easyii\behaviors
 */
class StatusController extends \yii\base\Behavior
{
    public $model;

    public function changeStatus($id, $status)
    {
        $modelClass = $this->model;

        if(($model = $modelClass::findOne($id))){
            $model->status = $status;
            if($model->update(false) && isset($model->children))
							$this->changeStatusForChildren($model,$status);
        }
        else{
            $this->error = Yii::t('app', 'Неможливо змінити статус запису');
        }

        return $this->owner->formatResponse(Yii::t('app', 'Запис з id={primaryKey} змінений', ['primaryKey'=>$model->primaryKey]));
    }
		public function changeStatusForChildren($model,$status)
		{
			foreach($model->children as $child) {
				$child->status = $status;
				$child->update(false);
				if(isset($child->children))
					$this->changeStatusForChildren($child,$status);
			}
		}
}