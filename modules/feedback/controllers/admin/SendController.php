<?php
namespace app\modules\feedback\controllers\admin;

use Yii;
use app\modules\feedback\models\Feedback as FeedbackModel;

class SendController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $model = new FeedbackModel;

        $request = Yii::$app->request;

        if ($model->load($request->post())) {
            $returnUrl = $model->save() ? $request->post('successUrl') : $request->post('errorUrl');
            return $this->redirect($returnUrl);
        } else {
            return $this->redirect(Yii::$app->request->baseUrl);
        }
    }
}