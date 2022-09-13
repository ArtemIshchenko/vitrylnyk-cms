<?php

namespace app\modules\article\controllers;

use Yii;
use app\modules\article\api\Article;

class ReceptesController extends \yii\web\Controller
{
		public $layout = '@app/views/userlayouts/main';
    public function actionIndex()
    {
				$cat = null;
				$cat = Article::cat('recepty');
					
        return $this->render('index', ['cat' => $cat]);
    }
		
    public function actionView($slug)
    {
				$cat = Article::cat('recepty');
        $article = Article::get($slug);
        if(!$article){
            throw new \yii\web\NotFoundHttpException('Article not found.');
        }
				

        return $this->render('view', [
            'article' => $article,
						'cat' =>$cat,
						'url' => Yii::$app->request->url
        ]);
    }
}
