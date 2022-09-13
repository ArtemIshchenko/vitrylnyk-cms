<?php
namespace app\modules\file\controllers\admin;

use Yii;
use yii\data\ActiveDataProvider;
use yii\widgets\ActiveForm;
use yii\web\UploadedFile;

use app\components\Controller;
use app\modules\file\models\File;
use app\helpers\Upload;
use app\behaviors\ControlPositionController;

class AController extends Controller
{
    public function behaviors()
    {
        return [
            [
                'class' => ControlPositionController::className(),
                'modelClass' => File::className()
            ],
        ];
    }

    public function actionIndex()
    {
        $data = new ActiveDataProvider([
            'query' => File::find()->sortPos(),
        ]);
        return $this->render('index', [
            'data' => $data
        ]);
    }

    public function actionCreate($slug = null)
    {
        $model = new File;

        if ($model->load(Yii::$app->request->post())) {
            if(Yii::$app->request->isAjax){
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            else{
                if(($fileInstanse = UploadedFile::getInstance($model, 'file')))
                {
                    $model->file = $fileInstanse;
                    if($model->validate(['file'])){
                        $model->file = Upload::file($fileInstanse, 'files', false);
                        $model->size = $fileInstanse->size;

                        if($model->save()){
                            $this->flash('success', Yii::t('file', 'Файл створений'));
                            return $this->redirect(['/'.$this->module->id.'/admin']);
                        }
                        else{
                            $this->flash('error', Yii::t('app', 'Помилка. {0}', $model->formatErrors()));
                        }
                    }
                    else {
                        $this->flash('error', Yii::t('file', 'Помилка. {0}', $model->formatErrors()));
                    }
                }
                else {
                    $this->flash('error', Yii::t('yii', '{attribute} cannot be blank.', ['attribute' => $model->getAttributeLabel('file')]));
                }
                return $this->refresh();
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
        $model = File::findOne($id);

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
                if(($fileInstanse = UploadedFile::getInstance($model, 'file')))
                {
                    $model->file = $fileInstanse;
                    if($model->validate(['file'])){
                        $model->file = Upload::file($fileInstanse, 'files', false);
                        $model->size = $fileInstanse->size;
                        $model->time = time();
                    }
                    else {
                        $this->flash('error', Yii::t('file', 'Помилка. {0}', $model->formatErrors()));
                        return $this->refresh();
                    }
                }
                else{
                    $model->file = $model->oldAttributes['file'];
                }

                if($model->save()){
                    $this->flash('success', Yii::t('file', 'Файл оновлений'));
                }
                else {
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
        if(($model = File::findOne($id))){
            $model->delete();
        } else {
            $this->error = Yii::t('app', 'Запис не знайдений');
        }
        return $this->formatResponse(Yii::t('file', 'Запис видалений'));
    }

    public function actionUp($id)
    {
        return $this->posUp($id);
    }

    public function actionDown($id)
    {
        return $this->posDown($id);
    }
}