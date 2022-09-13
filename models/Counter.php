<?php
namespace app\models;

use Yii;

class Counter extends \app\components\ActiveRecord
{
		const SORT_ASCENDING = 'asc';
		const SORT_DESCENDING = 'desc';
		const COUT_SUCCESS_RESPONSE = 1;
		const COUT_UNSUCCESS_RESPONSE = 2;
		const STATUS_OK = 'OK';
		public $date = '';
    public static function tableName()
    {
        return 'statistic';
    }
		
		public static function setCounters()
    {
			$view = Yii::$app->getView();
      $result = self::find()->where(['url' => Yii::$app->request->url, 'last_status' => Yii::$app->response->statusText, 'title' => $view->title])->one();
			if($result) {
				$result->updateCounters(['count' => 1]);
				$result->last_status = Yii::$app->response->statusText;
				$result->last_time = time();
				$result->save(true, ['last_status', 'last_time']);
			}
			else {
				(new self(['url' => Yii::$app->request->url,
									'title' => $view->title,
									'count' => 1,
									'last_status' => Yii::$app->response->statusText,
									'last_time' => time()]))
								->save();
			}
    }
		public static function addSort($sort = [])
    {
			$route = [];
			$params = ['title', 'url', 'last_time', 'last_status', 'count'];
			foreach($params as $value) {
				if(!empty($sort[$value]))
					$direct = $sort[$value]==self::SORT_ASCENDING ? self::SORT_DESCENDING : self::SORT_ASCENDING;
				else
					$direct = self::SORT_ASCENDING;
				$route[$value] = ['', 'sort[' . $value . ']' => $direct];
				if(array_key_exists($value, $sort))
					$route[$value] = array_merge($route[$value], ['sort[' . $value . ']'=> $direct]);
				foreach($sort as $key=>$val) {
					if($key!=$value)
						$route[$value] = array_merge($route[$value], ['sort[' . $key . ']'=> $val]);
				}
			}
			return $route;
		}
		public static function search($sort)
    {
			$orderBy = [];
			if(empty($sort)) {
				$orderBy['last_time'] = SORT_ASC;
			}
			else {
				foreach($sort as $key=>$value) {
					if($value == self::SORT_ASCENDING)
						$orderBy[$key] = SORT_ASC;
					else
						$orderBy[$key] = SORT_DESC;
				}
			}
      $result = self::find()->orderBy($orderBy)->all();
			return $result;
    }
		public static function isPrimarySort($sort, $key)
    {
			if($sort) {
				$keys = array_keys($sort);
				return $keys[0] == $key;
			}
			return false;
    }
		public static function getCount($models, $typeResponse=false)
    {
			$c = 0;
			foreach($models as $model) {
				if($typeResponse == self::COUT_SUCCESS_RESPONSE) {
					if($model->last_status == self::STATUS_OK)
						$c += $model->count;
				}
				elseif($typeResponse == self::COUT_UNSUCCESS_RESPONSE) {
					if($model->last_status != self::STATUS_OK)
						$c += $model->count;
				}
				else
					$c += $model->count;
			}
			return $c;
    }
		public static function getCountViews()
    {
			$counts = self::find()->select('count')->asArray()->all();
			$view = 0;
			foreach($counts as $count) {
				$view += $count['count'];
			}
			return $view;
    }
		public function afterFind()
		{
			$this->date = date('d-m-Y H:i:s', $this->last_time);
			parent:: afterFind();
		}
}