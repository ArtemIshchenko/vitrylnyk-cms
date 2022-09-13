<?php
namespace app\modules\admin\controllers;

class DefaultController extends \app\components\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}