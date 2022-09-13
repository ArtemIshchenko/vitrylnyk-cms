<?php
namespace app\modules\news\controllers\admin;

use Yii;
use yii\data\ActiveDataProvider;
use yii\widgets\ActiveForm;
use yii\web\UploadedFile;

use app\components\Controller;
use app\modules\news\models\News;
use app\helpers\Image;
use app\behaviors\ControlPositionController;
use app\behaviors\StatusController;

class AController extends Controller
{
    public function behaviors()
    {
        return [
           [
								'class' => ControlPositionController::className(),
								'modelClass' => News::className()
           ],
            [
                'class' => StatusController::className(),
                'model' => News::className()
            ]
        ];
    }

    public function actionIndex()
    {
        $data = new ActiveDataProvider([
            'query' => News::find()->sortDate(),
        ]);

        return $this->render('index', [
            'data' => $data
        ]);
    }

    public function actionCreate()
    {
        $model = new News;
        $model->time = time();

        if ($model->load(Yii::$app->request->post())) {
            if(Yii::$app->request->isAjax){
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            else {
                if(isset($_FILES) && $this->module->settings['enableThumb']){
                    $model->image = UploadedFile::getInstance($model, 'image');
                    if($model->image && $model->validate(['image'])){
                        $model->image = Image::upload($model->image, 'news');
                    }
                    else{
                        $model->image = '';
                    }
                }
                if($model->save()){
                    $this->flash('success', Yii::t('news', 'Новина створена'));
                    return $this->redirect(['/'.$this->module->id .'/admin']);
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
        $model = News::findOne($id);

        if($model === null){
            $this->flash('error', Yii::t('app', 'Запис не знайдений'));
            return $this->redirect(['/'.$this->module->id.'/admin']);
        }

        if ($model->load(Yii::$app->request->post())) {
            if(Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            else {
                if(isset($_FILES) && $this->module->settings['enableThumb']){
                    $model->image = UploadedFile::getInstance($model, 'image');
                    if($model->image && $model->validate(['image'])){
                        $model->image = Image::upload($model->image, 'news');
                    }
                    else{
                        $model->image = $model->oldAttributes['image'];
                    }
                }

                if($model->save()) {
                    $this->flash('success', Yii::t('news', 'Новина оновлена'));
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

    public function actionPhotos($id)
    {
        if(!($model = News::findOne($id))){
            return $this->redirect(['/'.$this->module->id.'/admin']);
        }

        return $this->render('photos', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        if(($model = News::findOne($id))){
            $model->delete();
        } else {
            $this->error = Yii::t('app', 'Запис не знайдений');
        }
        return $this->formatResponse(Yii::t('news', 'Новина видалена'));
    }

    public function actionClearImage($id)
    {
        $model = News::findOne($id);

        if($model === null){
            $this->flash('error', Yii::t('app', 'Запис не знайдений'));
        }
        else{
            $model->image = '';
            if($model->update()){
                @unlink(Yii::getAlias('@webroot').$model->image);
                $this->flash('success', Yii::t('app', 'Малюнок видалений'));
            } else {
                $this->flash('error', Yii::t('app', 'Помилка. {0}', $model->formatErrors()));
            }
        }
        return $this->back();
    }

		public function actionUp($id)
    {
        return $this->posUp($id);
    }

    public function actionDown($id)
    {
        return $this->posDown($id);
    }

    public function actionOn($id) {
				return $this->changeStatus($id, News::STATUS_ON);
		}

    public function actionOff($id) {
				return $this->changeStatus($id, News::STATUS_OFF);
		}
}