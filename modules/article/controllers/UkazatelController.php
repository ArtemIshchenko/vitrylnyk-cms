<?php

namespace app\modules\article\controllers;

use app\modules\article\api\Article;

class UkazatelController extends \yii\web\Controller
{
		public $layout = '@app/views/userlayouts/main';
    public function actionIndex()
    {
				$cat = Article::cat('ukazatel');
        return $this->render('index', ['cat' => $cat]);
    }
}
