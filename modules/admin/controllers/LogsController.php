<?php
namespace app\modules\admin\controllers;

use yii\data\ActiveDataProvider;

use app\modules\admin\models\LoginForm;

class LogsController extends \app\components\Controller
{
    public $rootActions = 'all';

    public function actionIndex()
    {
        $data = new ActiveDataProvider([
            'query' => LoginForm::find()->desc(),
        ]);

        return $this->render('index', [
            'data' => $data
        ]);
    }
}