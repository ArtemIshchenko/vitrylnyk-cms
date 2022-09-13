<?php

namespace app\modules\gallery\controllers;

use app\modules\gallery\api\Gallery;

class GalleryController extends \yii\web\Controller
{
		public $layout = '@app/views/userlayouts/main';
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionView($slug)
    {
        $album = Gallery::cat($slug);
        if(!$album){
            throw new \yii\web\NotFoundHttpException('Альбом не знайдений.');
        }

        return $this->render('view', [
            'album' => $album,
            'photos' => $album->photos(['pagination' => ['pageSize' => 4]])
        ]);
    }
}
