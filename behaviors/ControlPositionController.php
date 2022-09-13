<?php
namespace app\behaviors;

use Yii;
use app\models\Module;
class ControlPositionController extends \yii\base\Behavior
{
    public $modelClass;
		public function init() {
				if($this->modelClass==null)
					throw new \yii\web\ServerErrorHttpException('Властивість "modelClass" не визначена у классі' . get_class($this));
		}
		public function loadModel($id, $class) {
				$modelClass = $this->modelClass;
				$conditions = !$class ? ['id'=>$id] : ['id'=>$id, 'class'=>$class];
				if($model = $modelClass::findOne($conditions)) {
					return $model;
				}
				$this->owner->error = Yii::t('app', 'Запис не знайдений');
				return false;
		}
		public function posUp($id, $class=null) {
				$success = '';
				if($model = $this->loadModel($id, $class)) {
					if($model->up())
						$success = ['message' =>Yii::t('app', 'Запис з id={primaryKey} переміщенний вгору', ['primaryKey'=>$model->primaryKey]),
												'swap_id' => $model->swap_id
												];
					else
						$this->owner->error = Yii::t('app', 'Неможливо перемістити запис');
				}
				return $this->owner->formatResponse($success);
		}
		public function posDown($id, $class=null) {
				$success = '';
				if($model = $this->loadModel($id, $class)) {
					if($model->down())
						$success = ['message' =>Yii::t('app', 'Запис з id={primaryKey} переміщенний вниз', ['primaryKey'=>$model->primaryKey]),
												'swap_id' => $model->swap_id
												];
					else
						$this->owner->error = Yii::t('app', 'Неможливо перемістити запис');
				}
				return $this->owner->formatResponse($success);
		}
}