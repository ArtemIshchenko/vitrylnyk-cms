<?php
namespace app\modules\admin\controllers;

use Yii;
use yii\widgets\ActiveForm;
use app\modules\admin\models\Setting;

class SettingsController extends \app\components\Controller
{
    public $rootActions = ['create', 'delete'];

    public function actionIndex()
    {
        return $this->render('index', [
            'data' => Setting::search()
        ]);
    }

    public function actionCreate()
    {
        $model = new Setting;

        if ($model->load(Yii::$app->request->post())) {
            if(Yii::$app->request->isAjax){
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            else {
                if($model->save()) {
                    $this->flash('success', Yii::t('app', 'Налаштування створено'));
                    return $this->redirect('/admin/settings');
                }
                else {
                    $this->flash('error', Yii::t('app', 'Помилка. {0}', $model->formatErrors()));
                    return $this->refresh();
                }
            }
        }
        else {
            return $this->render('create', [
                'model' => $model
            ]);
        }
    }

    public function actionEdit($id)
    {
        $model = Setting::findOne($id);

        if($model === null || ($model->visibility < (IS_ROOT ? Setting::VISIBLE_ROOT : Setting::VISIBLE_ALL))){
            $this->flash('error', Yii::t('app', 'Запис не знайдений'));
            return $this->redirect(['settings']);
        }

        if ($model->load(Yii::$app->request->post())) {
            if(Yii::$app->request->isAjax){
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            else{
                if($model->save()){
                    $this->flash('success', Yii::t('app', 'Налаштування оновлено'));
                }
                else{
                    $this->flash('error', Yii::t('app', 'Помилка. {0}', $model->formatErrors()));
                }
                return $this->refresh();
            }
        }
        else {
            return $this->render('edit', [
                'model' => $model
            ]);
        }
    }

    public function actionDelete($id)
    {
        if(($model = Setting::findOne($id))){
            $model->delete();
        } else {
            $this->error = Yii::t('app', 'Запис не знайдений');
        }
        return $this->formatResponse(Yii::t('app', 'Налаштування видалено'));
    }
}