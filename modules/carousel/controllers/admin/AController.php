<?php
namespace app\modules\carousel\controllers\admin;

use Yii;
use yii\data\ActiveDataProvider;
use yii\widgets\ActiveForm;
use yii\web\UploadedFile;

use app\components\Controller;
use app\modules\carousel\models\Carousel;
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
                'modelClass' => Carousel::className()
            ],
            [
                'class' => StatusController::className(),
                'model' => Carousel::className()
            ]
        ];
    }

    public function actionIndex()
    {
        $data = new ActiveDataProvider([
            'query' => Carousel::find()->sortPos(),
        ]);
        return $this->render('index', [
            'data' => $data
        ]);
    }

    public function actionCreate()
    {
        $model = new Carousel;

        if ($model->load(Yii::$app->request->post())) {
            if(Yii::$app->request->isAjax){
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            else{
                if(($fileInstanse = UploadedFile::getInstance($model, 'image')))
                {
                    $model->image = $fileInstanse;
                    if($model->validate(['image'])){
                        $model->image = Image::upload($model->image, 'carousel');
                        $model->status = Carousel::STATUS_ON;

                        if($model->save()){
                            $this->flash('success', Yii::t('carousel', 'Карусель створена'));
                            return $this->redirect(['/'.$this->module->id.'/admin']);
                        }
                        else{
                            $this->flash('error', Yii::t('app', 'Помилка. {0}', $model->formatErrors()));
                        }
                    }
                    else {
                        $this->flash('error', Yii::t('app', 'Помилка. {0}', $model->formatErrors()));
                    }
                }
                else {
                    $this->flash('error', Yii::t('yii', '{attribute} cannot be blank.', ['attribute' => $model->getAttributeLabel('image')]));
                }
                return $this->refresh();
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
        $model = Carousel::findOne($id);

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
                if(($fileInstanse = UploadedFile::getInstance($model, 'image')))
                {
                    $model->image = $fileInstanse;
                    if($model->validate(['image'])){
                        $model->image = Image::upload($model->image, 'carousel');
                    }
                    else {
                        $this->flash('error', Yii::t('app', 'Помилка. {0}', $model->formatErrors()));
                        return $this->refresh();
                    }
                }
                else{
                    $model->image = $model->oldAttributes['image'];
                }

                if($model->save()){
                    $this->flash('success', Yii::t('carousel', 'Карусель оновлена'));
                }
                else{
                    $this->flash('error', Yii::t('carousel','Помилка. {0}', $model->formatErrors()));
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
        if(($model = Carousel::findOne($id))){
            $model->delete();
        } else {
            $this->error = Yii::t('app', 'Запис не знайдений');
        }
        return $this->formatResponse(Yii::t('carousel', 'Пункт каруселі видалений'));
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
				return $this->changeStatus($id, Carousel::STATUS_ON);
		}

    public function actionOff($id) {
				return $this->changeStatus($id, Carousel::STATUS_OFF);
		}
}