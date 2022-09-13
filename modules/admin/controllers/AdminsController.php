<?php
namespace app\modules\admin\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\widgets\ActiveForm;
use app\modules\admin\models\Admin;

class AdminsController extends \app\components\Controller
{
    public $rootActions = 'all';

    public function actionIndex()
    {
        return $this->render('index', [
            'data' => Admin::search()
        ]);
    }

    public function actionCreate()
    {
        $model = new Admin;
        $model->scenario = 'create';
        if ($model->load(Yii::$app->request->post())) {
            if(Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            else{
                if($model->save()) {
                    $this->flash('success', Yii::t('admin', 'Запис створений'));
                    return $this->redirect(['/admin/admins']);
                }
                else {
                    $this->flash('error', Yii::t('admin', 'Помилка. {0}', $model->formatErrors()));
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
        $model = Admin::findOne($id);

        if($model === null) {
            $this->flash('error', Yii::t('admin', 'Запис не знайдений'));
            return $this->redirect(['/admin/admins']);
        }

        if ($model->load(Yii::$app->request->post())) {
            if(Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            else {
                if($model->save()) {
                    $this->flash('success', Yii::t('admin', 'Запис оновлений'));
                }
                else {
                    $this->flash('error', Yii::t('admin', 'Помилка. {0}', $model->formatErrors()));
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
        if(($model = Admin::findOne($id))){
            $model->delete();
        } else {
            $this->error = Yii::t('admin', 'Запис не знайдений');
        }
        return $this->formatResponse(Yii::t('admin', 'Запис видалений'));
    }
}