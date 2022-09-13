<?php
namespace app\modules\shopcart\controllers\admin;

use Yii;
use app\modules\shopcart\api\Shopcart;
use app\modules\shopcart\models\Order;

class SendController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $model = new Order();
        $request = Yii::$app->request;

        if($model->load($request->post())) {
            $returnUrl = Shopcart::send($model->attributes) ? $request->post('successUrl') : $request->post('errorUrl');
            return $this->redirect($returnUrl);
        } else {
            return $this->redirect(Yii::$app->request->baseUrl);
        }
    }
}