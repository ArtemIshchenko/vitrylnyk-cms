<?php

namespace app\modules\faq\controllers;

class FaqController extends \yii\web\Controller
{
		public $layout = '@app/views/userlayouts/main';
    public function actionIndex()
    {
        return $this->render('index');
    }

}
