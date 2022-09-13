<?php
namespace app\modules\news\controllers;

use app\modules\news\api\News;

class NewsController extends \yii\web\Controller
{
		public $layout = '@app/views/userlayouts/main';
    public function actionIndex($tag = null)
    {
        return $this->render('index',[
            'news' => News::items(['tags' => $tag, 'pagination' => ['pageSize' => 2]])
        ]);
    }

    public function actionView($slug)
    {
        $news = News::get($slug);
        if(!$news){
            throw new \yii\web\NotFoundHttpException('News not found.');
        }

        return $this->render('view', [
            'news' => $news
        ]);
    }
}
