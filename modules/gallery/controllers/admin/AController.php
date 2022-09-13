<?php
namespace app\modules\gallery\controllers\admin;

use app\components\CategoryController;
use app\modules\gallery\models\Category;

class AController extends CategoryController
{
    public $categoryClass = 'app\modules\gallery\models\Category';
    public $moduleName = 'gallery';
    public $viewRoute = '/admin/a/photos';

    public function actionPhotos($id)
    {
        if(!($model = Category::findOne($id))){
            return $this->redirect(['/'.$this->module->id.'/admin']);
        }

        return $this->render('photos', [
            'model' => $model,
        ]);
    }
}