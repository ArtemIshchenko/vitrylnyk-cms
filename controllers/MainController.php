<?php

namespace app\controllers;

use Yii;
use app\modules\page\models\Page;
use app\modules\article\api\Article;

class MainController extends \yii\web\Controller
{
		public $layout = '@app/views/userlayouts/main';
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        if(!Yii::$app->installed){
            return $this->redirect(['/install/step1']);
        }
        $cat = Article::cat('main');
        if(!$cat) {
            throw new \yii\web\NotFoundHttpException('Article category not found.');
        }
        return $this->render('index', ['cat' => $cat]);
    }
		public function actionView($slug)
    {
        $art = Article::get($slug);
        if(!$art) {
            throw new \yii\web\NotFoundHttpException('Article not found.');
        }
        return $this->render('view', ['article' => $art]);
    }
		public function actionService()
    {
        return $this->renderPartial('service');
    }
}