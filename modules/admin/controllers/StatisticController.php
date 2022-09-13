<?php
namespace app\modules\admin\controllers;

use Yii;
use yii\widgets\ActiveForm;
use app\models\Counter;

class StatisticController extends \app\components\Controller
{
    public $rootActions = ['delete'];

    public function actionIndex(array $sort=[])
    {
        return $this->render('index', [
            'models' => Counter::search($sort),
						'route' => Counter::addSort($sort),
						'sort' => $sort
        ]);
    }

    public function actionDelete()
    {
      if(Counter::deleteAll())
				return $this->formatResponse(Yii::t('app', 'Лічільники скинуті'));
			else
				return $this->formatResponse(Yii::t('app', 'Лічільники вже були скинуті'));
    }
}