<?php

namespace app\modules\catalog\controllers;

use app\modules\catalog\api\Catalog;

class SborController extends \yii\web\Controller
{
		public $layout = '@app/views/userlayouts/main';
    public function actionIndex()
    {
				$list = Catalog::table('sbor');
        return $this->render('index', ['list' => $list]);
    }
}
