<?php
namespace app\modules\feedback\models;

use Yii;
use app\behaviors\CalculateNotice;
use app\helpers\Mail;
use app\models\Setting;
use app\validators\ReCaptchaValidator;
use app\validators\EscapeValidator;
use yii\helpers\Url;

class Feedback extends \app\components\ActiveRecord
{
    const STATUS_NEW = 0;
    const STATUS_VIEW = 1;
    const STATUS_ANSWERED = 2;

    const FLASH_KEY = 'feedback_send_result';

    public $reCaptcha;

    public static function tableName()
    {
        return 'feedback';
    }

    public function rules()
    {
        return [
            [['name', 'email', 'text'], 'required'],
            [['name', 'email', 'phone', 'title', 'text'], 'trim'],
            [['name','title', 'text'], EscapeValidator::className()],
            ['title', 'string', 'max' => 128],
            ['email', 'email'],
            ['phone', 'match', 'pattern' => '/^[\d\s-\+\(\)]+$/'],
            ['reCaptcha', ReCaptchaValidator::className(), 'when' => function($model){
                return $model->isNewRecord && Yii::$app->activeModules['feedback']->settings['enableCaptcha'];
            }],
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if($insert){
                $this->ip = Yii::$app->request->userIP;
                $this->time = time();
                $this->status = self::STATUS_NEW;
            }
            return true;
        } else {
            return false;
        }
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if($insert){
            $this->mailAdmin();
        }
    }

    public function attributeLabels()
    {
        return [
            'email' => 'E-mail',
            'name' => Yii::t('app', 'Name'),
            'title' => Yii::t('app', 'Title'),
            'text' => Yii::t('app', 'Text'),
            'answer_subject' => Yii::t('feedback', 'Subject'),
            'answer_text' => Yii::t('app', 'Text'),
            'phone' => Yii::t('feedback', 'Phone'),
            'reCaptcha' => Yii::t('app', 'Anti-spam check')
        ];
    }

    public function behaviors()
    {
        return [
            'cn' => [
                'class' => CalculateNotice::className(),
                'callback' => function(){
                    return self::find()->status(self::STATUS_NEW)->count();
                }
            ]
        ];
    }

    public function mailAdmin()
    {
        $settings = Yii::$app->activeModules['feedback']->settings;

        if(!$settings['mailAdminOnNewFeedback']){
            return false;
        }
        return Mail::send(
            Setting::get('admin_email'),
            $settings['subjectOnNewFeedback'],
            $settings['templateOnNewFeedback'],
            ['feedback' => $this, 'link' => Url::to(['/feedback/admin/a/view', 'id' => $this->primaryKey], true)]
        );
    }

    public function sendAnswer()
    {
        $settings = Yii::$app->activeModules['feedback']->settings;

        return Mail::send(
            $this->email,
            $this->answer_subject,
            $settings['answerTemplate'],
            ['feedback' => $this],
            ['replyTo' => Setting::get('admin_email')]
        );
    }
}