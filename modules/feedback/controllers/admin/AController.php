<?php
namespace app\modules\feedback\controllers\admin;

use Yii;
use yii\data\ActiveDataProvider;

use app\components\Controller;
use app\models\Setting;
use app\modules\feedback\models\Feedback;

class AController extends Controller
{
    public $new = 0;
    public $noAnswer = 0;

    public function init()
    {
        parent::init();

        $this->new = Yii::$app->activeModules['feedback']->notice;
        $this->noAnswer = Feedback::find()->status(Feedback::STATUS_VIEW)->count();
    }

    public function actionIndex()
    {
        $data = new ActiveDataProvider([
            'query' => Feedback::find()->status(Feedback::STATUS_NEW)->asc(),
        ]);
        return $this->render('index', [
            'data' => $data
        ]);
    }

    public function actionNoanswer()
    {
        $this->setReturnUrl();

        $data = new ActiveDataProvider([
            'query' => Feedback::find()->status(Feedback::STATUS_VIEW)->asc(),
        ]);
        return $this->render('index', [
            'data' => $data
        ]);
    }

    public function actionAll()
    {
        $this->setReturnUrl();

        $data = new ActiveDataProvider([
            'query' => Feedback::find()->desc(),
        ]);
        return $this->render('index', [
            'data' => $data
        ]);
    }

    public function actionView($id)
    {
        $model = Feedback::findOne($id);

        if($model === null){
            $this->flash('error', Yii::t('app', 'Запис не зайдений'));
            return $this->redirect(['/'.$this->module->id.'/admin']);
        }

        if($model->status == Feedback::STATUS_NEW){
            $model->status = Feedback::STATUS_VIEW;
            $model->update();
        }

        $postData = Yii::$app->request->post('Feedback');
        if($postData) {
            if(filter_var(Setting::get('admin_email'), FILTER_VALIDATE_EMAIL))
            {
                $model->answer_subject = filter_var($postData['answer_subject'], FILTER_SANITIZE_STRING);
                $model->answer_text = filter_var($postData['answer_text'], FILTER_SANITIZE_STRING);
                if($model->sendAnswer()){
                    $model->status = Feedback::STATUS_ANSWERED;
                    $model->save();
                    $this->flash('success', Yii::t('feedback', 'Відповідь успішно відправлена'));
                }
                else{
                    $this->flash('error', Yii::t('feedback', 'Виникла помилка при відправці пошти'));
                }
            }
            else {
                $this->flash('error', Yii::t('feedback', 'Будь ласка заповніть коректно `Admin E-mail` в налаштуваннях'));
            }

            return $this->refresh();
        }
        else {
            if(!$model->answer_text) {
                $model->answer_subject = Yii::t('feedback', $this->module->settings['answerSubject']);
                if ($this->module->settings['answerHeader']) $model->answer_text = Yii::t('feedback', $this->module->settings['answerHeader']) . " " . $model->name . ".\n";
                if ($this->module->settings['answerFooter']) $model->answer_text .= "\n\n" . Yii::t('feedback', $this->module->settings['answerFooter']);
            }

            return $this->render('view', [
                'model' => $model
            ]);
        }
    }

    public function actionSetAnswer($id)
    {
        $model = Feedback::findOne($id);

        if($model === null){
            $this->flash('error', Yii::t('app', 'Запис не знайдений'));
        }
        else{
            $model->status = Feedback::STATUS_ANSWERED;
            if($model->update()) {
                $this->flash('success', Yii::t('feedback', 'Звортній зв\'язок оновлений'));
            }
            else{
                $this->flash('error', Yii::t('app', 'Помилка. {0}', $model->formatErrors()));
            }
        }
        return $this->back();
    }

    public function actionDelete($id)
    {
        if(($model = Feedback::findOne($id))){
            $model->delete();
        } else {
            $this->error = Yii::t('app', 'Запис не знайдений');
        }
        return $this->formatResponse(Yii::t('feedback', 'Звортній зв\'язок видалений'));
    }
}