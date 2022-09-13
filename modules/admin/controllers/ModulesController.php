<?php
namespace app\modules\admin\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use app\modules\admin\models\CopyModuleForm;
use yii\helpers\FileHelper;
use yii\widgets\ActiveForm;
use app\modules\admin\models\Module;
use app\modules\admin\controllers\InstallController;
use app\behaviors\ControlPositionController;
use app\behaviors\StatusController;

class ModulesController extends \app\components\Controller
{
    public $rootActions = 'all';

    public function behaviors()
    {
        return [
           [
								'class' => ControlPositionController::className(),
								'modelClass' => Module::className()
           ],
					 [
                'class' => StatusController::className(),
                'model' => Module::className()
            ]
        ];
    }

    public function actionIndex()
    {
        return $this->render('index', [
            'data' => Module::search()
        ]);
    }

    public function actionCreate()
    {
        $model = new Module;

        if ($model->load(Yii::$app->request->post())) {
            if(Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            else {
								$installController = new InstallController('install','admin');
                if($installController->installModule($model)) {
                    $this->flash('success', Yii::t('app', 'Модуль створений'));
                    return $this->redirect(['/admin/modules']);
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
        $model = Module::findOne($id);

        if($model === null){
            $this->flash('error', Yii::t('app', 'Запис не знайдений'));
            return $this->redirect(['/admin/modules']);
        }

        if ($model->load(Yii::$app->request->post())) {
            if(Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            else {
                if($model->save()){
                    $this->flash('success', Yii::t('app', 'Модуль оновлений'));
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

    public function actionSettings($id)
    {
        $model = Module::findOne($id);

        if($model === null){
            $this->flash('error', Yii::t('app', 'Запис не знайдений'));
            return $this->redirect(['/admin/modules']);
        }

        if (Yii::$app->request->post('Settings')) {
            $model->setSettings(Yii::$app->request->post('Settings'));
            if($model->save()) {
                $this->flash('success', Yii::t('app', 'Налаштування модуля оновлені'));
            }
            else {
                $this->flash('error', Yii::t('app', Yii::t('easyii', 'Помилка. {0}', $model->formatErrors())));
            }
            return $this->refresh();
        }
        else {
            return $this->render('settings', [
                'model' => $model
            ]);
        }
    }

    public function actionRestoreSettings($id)
    {
        if(($model = Module::findOne($id))) {
            $model->settings = '';
            $model->save();
            $this->flash('success', Yii::t('app', 'Налаштування модуля за замовчуванням були встановлені'));
        } else {
            $this->flash('error', Yii::t('app', 'Запис не знайденний'));
        }
        return $this->back();
    }

    public function actionDelete($id)
    {
        if($model = Module::findOne($id)) {
            $model->delete();
        } else {
            $this->error = Yii::t('app', 'Запис не знайдений');
        }
        return $this->formatResponse(Yii::t('app', 'Модуль видалений'));
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
				return $this->changeStatus($id, Module::STATUS_ON);
		}
		public function actionOff($id) {
				return $this->changeStatus($id, Module::STATUS_OFF);
		}
}