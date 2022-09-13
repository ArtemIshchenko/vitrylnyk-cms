<?php

namespace app\modules\guestbook\controllers;

class GuestbookController extends \yii\web\Controller
{
		public $layout = '@app/views/userlayouts/main';
    public function actionIndex()
    {
        return $this->render('index');
    }

}
