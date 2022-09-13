<?php
namespace app\modules\shopcart\controllers\admin;

use Yii;

use app\components\Controller;
use app\modules\shopcart\models\Good;

class GoodsController extends Controller
{
    public function actionDelete($id)
    {
        if(($model = Good::findOne($id))){
            $model->delete();
        } else {
            $this->error = Yii::t('app', 'Запис не знайдений');
        }
        return $this->formatResponse(Yii::t('shopcart', 'Замовлення видалено'));
    }
}