<?php
namespace app\modules\article\controllers\admin;

use Yii;
use yii\web\UploadedFile;
use yii\widgets\ActiveForm;
use app\components\Controller;
use app\modules\article\models\Category;
use app\modules\article\models\Item;
use app\helpers\Image;
use app\behaviors\ControlPositionController;
use app\behaviors\StatusController;

class ItemsController extends Controller
{
    public function behaviors()
    {
        return [
            [
                'class' => ControlPositionController::className(),
                'modelClass' => Item::className(),
            ],
            [
								'class' => StatusController::className(),
								'model' => Item::className()
            ]
        ];
    }

    public function actionIndex($id)
    {
        if(!($model = Category::findOne($id))){
            return $this->redirect(['/'.$this->module->id.'/admin']);
        }

        return $this->render('index', [
            'model' => $model
        ]);
    }


    public function actionCreate($id)
    {
        if(!($category = Category::findOne($id))) {
            return $this->redirect(['/'.$this->module->id.'/admin']);
        }

        $model = new Item;

        if ($model->load(Yii::$app->request->post())) {
            if(Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            else {
                $model->category_id = $category->primaryKey;

                if (isset($_FILES) && $this->module->settings['articleThumb']) {
                    $model->image = UploadedFile::getInstance($model, 'image');
                    if ($model->image && $model->validate(['image'])) {
                        $model->image = Image::upload($model->image, 'article');
                    } else {
                        $model->image = '';
                    }
                }
                if ($model->save()) {
                    $this->flash('success', Yii::t('article', 'Стаття створена'));
                    return $this->redirect(['/'.$this->module->id.'/admin/items/edit', 'id' => $model->primaryKey]);
                } else {
                    $this->flash('error', Yii::t('app', 'Помилка. {0}', $model->formatErrors()));
                    return $this->refresh();
                }
            }
        }
        else {
            return $this->render('create', [
                'model' => $model,
                'category' => $category,
            ]);
        }
    }

    public function actionEdit($id)
    {
        if(!($model = Item::findOne($id))){
            return $this->redirect(['/'.$this->module->id.'/admin']);
        }

        if ($model->load(Yii::$app->request->post())) {
            if(Yii::$app->request->isAjax){
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            else {
                if (isset($_FILES) && $this->module->settings['articleThumb']) {
                    $model->image = UploadedFile::getInstance($model, 'image');
                    if ($model->image && $model->validate(['image'])) {
                        $model->image = Image::upload($model->image, 'article');
                    } else {
                        $model->image = $model->oldAttributes['image'];
                    }
                }

                if ($model->save()) {
                    $this->flash('success', Yii::t('article', 'Стаття оновлена'));
                    return $this->redirect(['/'.$this->module->id.'/admin/items/edit', 'id' => $model->primaryKey]);
                } else {
                    $this->flash('error', Yii::t('app', 'Помилка. {0}', $model->formatErrors()));
                    return $this->refresh();
                }
            }
        }
        else {
            return $this->render('edit', [
                'model' => $model,
            ]);
        }
    }

    public function actionPhotos($id)
    {
        if(!($model = Item::findOne($id))){
            return $this->redirect(['/'.$this->module->id.'/admin']);
        }

        return $this->render('photos', [
            'model' => $model,
        ]);
    }

    public function actionClearImage($id)
    {
        $model = Item::findOne($id);

        if($model === null){
            $this->flash('error', Yii::t('app', 'Запис не знайдений'));
        }
        elseif($model->image){
            $model->image = '';
            if($model->update()){
                $this->flash('success', Yii::t('app', 'Малюнок видалений'));
            } else {
                $this->flash('error', Yii::t('app', 'Помилка. {0}', $model->formatErrors()));
            }
        }
        return $this->back();
    }

    public function actionDelete($id)
    {
        if(($model = Item::findOne($id))){
            $model->delete();
        } else {
            $this->error = Yii::t('app', 'Запис не знайдений');
        }
        return $this->formatResponse(Yii::t('app', 'Стаття видалена'));
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
				return $this->changeStatus($id, Item::STATUS_ON);
		}

    public function actionOff($id) {
				return $this->changeStatus($id, Item::STATUS_OFF);
		}
}