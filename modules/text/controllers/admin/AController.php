<?php
namespace app\modules\text\controllers\admin;

use Yii;
use yii\data\ActiveDataProvider;
use yii\widgets\ActiveForm;

use app\components\Controller;
use app\modules\text\models\Text;

class AController extends Controller
{
    public $rootActions = ['create', 'delete'];

    public function actionIndex()
    {
        $data = new ActiveDataProvider([
            'query' => Text::find(),
        ]);
        return $this->render('index', [
            'data' => $data
        ]);
    }

    public function actionCreate($slug = null)
    {
        $model = new Text;

        if ($model->load(Yii::$app->request->post())) {
            if(Yii::$app->request->isAjax){
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            else{
                if($model->save()){
                    $this->flash('success', Yii::t('text', 'Текст створений'));
                    return $this->redirect(['/'.$this->module->id.'/admin']);
                }
                else{
                    $this->flash('error', Yii::t('app', 'Помилка. {0}', $model->formatErrors()));
                    return $this->refresh();
                }
            }
        }
        else {
            if($slug){
                $model->slug = $slug;
            }
            return $this->render('create', [
                'model' => $model
            ]);
        }
    }

    public function actionEdit($id)
    {
        $model = Text::findOne($id);

        if($model === null){
            $this->flash('error', Yii::t('app', 'Запис не знайдений'));
            return $this->redirect(['/'.$this->module->id.'/admin']);
        }

        if ($model->load(Yii::$app->request->post())) {
            if(Yii::$app->request->isAjax){
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            else{
                if($model->save()){
                    $this->flash('success', Yii::t('text', 'Текст оновлений'));
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
        if(($model = Text::findOne($id))){
            $model->delete();
        } else {
            $this->error = Yii::t('app', 'Запис не знайдений');
        }
        return $this->formatResponse(Yii::t('text', 'Текст видалений'));
    }
}