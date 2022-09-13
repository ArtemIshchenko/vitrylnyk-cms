<?php

namespace app\modules\article\controllers;

use app\modules\article\api\Article;

class ArticlesController extends \yii\web\Controller
{
		public $layout = '@app/views/userlayouts/main';
    public function actionIndex()
    {
				$cat = Article::cat('main');
        if(!$cat) {
            throw new \yii\web\NotFoundHttpException('Сторінка не знайдена.');
        }
        return $this->render('index', ['cat' => $cat]);
    }

    public function actionView($slug)
    {
        $article = Article::get($slug);
        if(!$article){
            throw new \yii\web\NotFoundHttpException('Сторінка не знайдена.');
        }

        return $this->render('view', [
            'article' => $article
        ]);
    }

}
