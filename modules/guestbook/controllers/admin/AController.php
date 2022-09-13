<?php
namespace app\modules\guestbook\controllers\admin;

use Yii;
use yii\data\ActiveDataProvider;

use app\behaviors\StatusController;
use app\components\Controller;
use app\modules\guestbook\models\Guestbook;

class AController extends Controller
{
    public $new = 0;
    public $noAnswer = 0;

    public function behaviors()
    {
        return [
            [
                'class' => StatusController::className(),
                'model' => Guestbook::className()
            ]
        ];
    }

    public function init()
    {
        parent::init();

        $this->new = Yii::$app->activeModules['guestbook']->notice;
        $this->noAnswer = Guestbook::find()->where(['answer' => ''])->count();
    }

    public function actionIndex()
    {
        $data = new ActiveDataProvider([
            'query' => Guestbook::find()->desc(),
        ]);

        return $this->render('index', [
            'data' => $data
        ]);
    }

    public function actionNoanswer()
    {
        $this->setReturnUrl();

        $data = new ActiveDataProvider([
            'query' => Guestbook::find()->where(['answer' => ''])->desc(),
        ]);
        return $this->render('index', [
            'data' => $data
        ]);
    }

    public function actionView($id)
    {
        $model = Guestbook::findOne($id);

        if($model === null){
            $this->flash('error', Yii::t('app', 'Запис не знайдений'));
            return $this->redirect(['/'.$this->module->id.'/admin']);
        }

        if($model->new > 0){
            $model->new = 0;
            $model->update();
        }

        if (Yii::$app->request->post('Guestbook')) {
            $model->answer = trim(Yii::$app->request->post('Guestbook')['answer']);
            if($model->save($model)){
                if(Yii::$app->request->post('mailUser')){
                    $model->notifyUser();
                }
                $this->flash('success', Yii::t('guestbook', 'Відповідь успішно збережена'));
            }
            else{
                $this->flash('error', Yii::t('app', 'Помилка. {0}', $model->formatErrors()));
            }
            return $this->refresh();
        }
        else {
            return $this->render('view', [
                'model' => $model
            ]);
        }
    }

    public function actionDelete($id)
    {
        if(($model = Guestbook::findOne($id))){
            $model->delete();
        } else {
            $this->error = Yii::t('app', 'Запис не знайдений');
        }
        return $this->formatResponse(Yii::t('guestbook', 'Запис видалений'));
    }

    public function actionViewall()
    {
        Guestbook::updateAll(['new' => 0]);
        $module = \app\modules\admin\models\Module::findOne(['name' => 'guestbook']);
        $module->notice = 0;
        $module->save();

        $this->flash('success', Yii::t('guestbook', 'Гостьова книга оновлена'));

        return $this->back();
    }

    public function actionSetnew($id)
    {
        $model = Guestbook::findOne($id);

        if($model === null){
            $this->flash('error', Yii::t('app', 'Запис не знайдений'));
        }
        else{
            $model->new = 1;
            if($model->update()) {
                $this->flash('success', Yii::t('guestbook', 'Гостьова книга оновлена'));
            }
            else{
                $this->flash('error', Yii::t('app', 'Помилка. {0}', $model->formatErrors()));
            }
        }
        return $this->redirect($this->getReturnUrl(['/'.$this->module->id.'/admin']));
    }

    public function actionOn($id)
    {
        return $this->changeStatus($id, Guestbook::STATUS_ON);
    }

    public function actionOff($id)
    {
        return $this->changeStatus($id, Guestbook::STATUS_OFF);
    }
}