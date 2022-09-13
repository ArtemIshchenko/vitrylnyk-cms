<?php
namespace app\components;

use Yii;
use yii\widgets\ActiveForm;
use yii\web\UploadedFile;
use app\helpers\Image;
use app\behaviors\ControlPositionController;
use app\behaviors\StatusController;

class CategoryController extends \app\components\Controller
{
    /** @var string */
    public $categoryClass;

    /** @var string  */
    public $viewRoute = '/admin/items/index';
		
		/** @var string  */
    public $createPage = '@app/views/category/create';
		
		/** @var string  */
    public $editPage = '@app/views/category/edit';
		
		public function behaviors()
    {
        return [
           [
								'class' => ControlPositionController::className(),
								'modelClass' => $this->categoryClass
           ],
					 [
                'class' => StatusController::className(),
                'model' => $this->categoryClass
            ]
        ];
    }

    /**
     * Categories list
     *
     * @return string
     */
    public function actionIndex()
    {
				$class = $this->categoryClass;
				if(!class_exists($class))
					throw new \yii\web\ServerErrorHttpException('Відсутній класс модели.');
        return $this->render('@app/views/category/index', [
            'categories' => $class::tree()
        ]);
    }

    /**
     * Create form
     *
     * @param null $parent
     * @return array|string|\yii\web\Response
     * @throws \yii\web\HttpException
     */
    public function actionCreate($parent = 0)
    {
        $class = $this->categoryClass;
        $model = new $class;

        if($model->load(Yii::$app->request->post())) {
            if(Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            else {
                if(isset($_FILES) && isset($this->module->settings['categoryThumb']) && $this->module->settings['categoryThumb']) {
                    $model->image = UploadedFile::getInstance($model, 'image');
                    if($model->image && $model->validate(['image'])) {
                        $model->image = Image::upload($model->image, $this->module->id);
                    } else {
                        $model->image = '';
                    }
                }

                $model->status = $class::STATUS_ON;

								$parent = (int)Yii::$app->request->post('parent', 0);
                if($parent == 0 || ($class::find()->where(['id'=>$parent])->exists())) {
                    $model->parent_id = $parent;
                    $model->save();
									if(!$model->hasErrors()) {
                    $this->flash('success', Yii::t('app', 'Категорія створена'));
                    return $this->redirect(['/'.$this->module->id.'/admin']);
									}
									else {
                    $this->flash('error', Yii::t('app', 'Помилка. {0}', $model->formatErrors()));
                    return $this->refresh();
									}
								}
            }
        }
        else {
            return $this->render($this->createPage, [
                'model' => $model,
                'parent' => $parent
            ]);
        }
    }

    /**
     * Edit form
     *
     * @param $id
     * @return array|string|\yii\web\Response
     * @throws \yii\web\HttpException
     */
    public function actionEdit($id)
    {
        $class = $this->categoryClass;

        if(!($model = $class::findOne($id))) {
            return $this->redirect(['/' . $this->module->id . '/admin']);
        }

        if ($model->load(Yii::$app->request->post())) {
            if(Yii::$app->request->isAjax){
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            else {
                if(isset($_FILES) && isset($this->module->settings['categoryThumb']) && $this->module->settings['categoryThumb']){
                    $model->image = UploadedFile::getInstance($model, 'image');
                    if($model->image && $model->validate(['image'])){
                        $model->image = Image::upload($model->image, $this->module->id);
                    }else{
                        $model->image = $model->oldAttributes['image'];
                    }
                }
                if($model->save()){
                    $this->flash('success', Yii::t('app', 'Категорія оновлена'));
                }
                else{
                    $this->flash('error', Yii::t('app', 'Помилка. {0}', $model->formatErrors()));
                }
                return $this->refresh();
            }
        }
        else {
            return $this->render($this->editPage, [
                'model' => $model
            ]);
        }
    }

    /**
     * Remove category image
     *
     * @param $id
     * @return \yii\web\Response
     */
    public function actionClearImage($id)
    {
        $class = $this->categoryClass;
        $model = $class::findOne($id);

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

    /**
     * Delete the category by ID
     *
     * @param $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $class = $this->categoryClass;
        if($model = $class::findOne($id)) {
            $model->delete();
        } else {
            $this->error = Yii::t('app', 'Запис не знайдений');
        }
        return $this->formatResponse(Yii::t('app', 'Категорія видалена'));
    }

    /**
     * Move category one level up up
     *
     * @param $id
     * @return \yii\web\Response
     */
		public function actionUp($id)
    {
        return $this->posUp($id);
    }

    /**
     * Move category one level down
     *
     * @param $id
     * @return \yii\web\Response
     */
    public function actionDown($id)
    {
        return $this->posDown($id);
    }

    /**
     * Activate category action
     *
     * @param $id
     * @return mixed
     */
    public function actionOn($id) {
				$class = $this->categoryClass;
				return $this->changeStatus($id, $class::STATUS_ON);
		}

    /**
     * Activate category action
     *
     * @param $id
     * @return mixed
     */
    public function actionOff($id) {
				$class = $this->categoryClass;
				return $this->changeStatus($id, $class::STATUS_OFF);
		}
}