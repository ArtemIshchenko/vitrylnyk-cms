<?php
namespace app\modules\subscribe\controllers\admin;

use Yii;
use app\modules\subscribe\api\Subscribe;
use yii\widgets\ActiveForm;

use app\modules\subscribe\models\Subscriber;

class SendController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $model = new Subscriber;
        $request = Yii::$app->request;

        if ($model->load($request->post())) {
            if($request->isAjax){
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            else{
                $returnUrl = $model->save() ? $request->post('successUrl') : $request->post('errorUrl');
                return $this->redirect($returnUrl);
            }
        }
        else {
            return $this->redirect(Yii::$app->request->baseUrl);
        }
    }

    public function actionUnsubscribe($email)
    {
        if($email && filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            Subscriber::deleteAll(['email' => $email]);
            echo '<h1>'.Yii::t('subscribe/api', 'Ви успішно відмовились від підписки!').'</h1>';
        }
        else{
            throw new \yii\web\BadRequestHttpException(Yii::t('subscribe/api', 'Не корректний E-mail'));
        }
    }
}