<?php
namespace app\modules\page\controllers\admin;

use Yii;
use yii\data\ActiveDataProvider;
use yii\widgets\ActiveForm;

use app\components\Controller;
use app\modules\page\models\Page;

class AController extends Controller
{
    public $rootActions = ['create', 'delete'];

    public function actionIndex()
    {
        $data = new ActiveDataProvider([
            'query' => Page::find()->desc()
        ]);
        return $this->render('index', [
            'data' => $data
        ]);
    }

    public function actionCreate($slug = null)
    {
        $model = new Page;

        if ($model->load(Yii::$app->request->post())) {
            if(Yii::$app->request->isAjax){
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            else{
                if($model->save()){
                    $this->flash('success', Yii::t('page', 'Сторінка створена'));
                    return $this->redirect(['/'.$this->module->id.'/admin']);
                }
                else{
                    $this->flash('error', Yii::t('app', 'Помилка. {0}', $model->formatErrors()));
                    return $this->refresh();
                }
            }
        }
        else {
            if($slug) $model->slug = $slug;

            return $this->render('create', [
                'model' => $model
            ]);
        }
    }

    public function actionEdit($id)
    {
        $model = Page::findOne($id);

        if($model === null){
            $this->flash('error', Yii::t('app', 'Not found'));
            return $this->redirect(['/'.$this->module->id.'/admin']);
        }

        if ($model->load(Yii::$app->request->post())) {
            if(Yii::$app->request->isAjax){
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            else{
                if($model->save()){
                    $this->flash('success', Yii::t('page', 'Сторінка оновлена'));
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
        if(($model = Page::findOne($id))){
            $model->delete();
        } else {
            $this->error = Yii::t('app', 'Запис не знайдений');
        }
        return $this->formatResponse(Yii::t('page', 'Запис видалений'));
    }
}