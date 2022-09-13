<?php
namespace app\modules\guestbook\models;

use Yii;
use app\behaviors\CalculateNotice;
use app\helpers\Mail;
use app\models\Setting;
use app\validators\ReCaptchaValidator;
use app\validators\EscapeValidator;
use yii\helpers\Url;

class Guestbook extends \app\components\ActiveRecord
{
    const STATUS_OFF = 0;
    const STATUS_ON = 1;
    const FLASH_KEY = 'guestbook_send_result';

    public $reCaptcha;

    public static function tableName()
    {
        return 'guestbook';
    }

    public function rules()
    {
        return [
            [['name', 'text'], 'required'],
            [['name', 'title', 'text'], 'trim'],
            [['name', 'title', 'text'], EscapeValidator::className()],
            ['email', 'email'],
            ['title', 'string', 'max' => 128],
            ['reCaptcha', ReCaptchaValidator::className(), 'on' => 'send', 'when' => function(){
                return Yii::$app->activeModules['guestbook']->settings['enableCaptcha'];
            }],
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if($insert){
                $this->ip = Yii::$app->request->userIP;
                $this->time = time();
                $this->new = 1;
                $this->status = Yii::$app->activeModules['guestbook']->settings['preModerate'] ? self::STATUS_OFF : self::STATUS_ON;
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
            'name' => Yii::t('app', 'Name'),
            'title' => Yii::t('app', 'Title'),
            'email' => 'E-mail',
            'text' => Yii::t('app', 'Text'),
            'answer' => Yii::t('guestbook', 'Answer'),
            'reCaptcha' => Yii::t('app', 'Anti-spam check')
        ];
    }

    public function behaviors()
    {
        return [
            'cn' => [
                'class' => CalculateNotice::className(),
                'callback' => function(){
                    return self::find()->where(['new' => 1])->count();
                }
            ]
        ];
    }

    public function mailAdmin()
    {
        $settings = Yii::$app->activeModules['guestbook']->settings;

        if(!$settings['mailAdminOnNewPost']){
            return false;
        }
        return Mail::send(
            Setting::get('admin_email'),
            $settings['subjectOnNewPost'],
            $settings['templateOnNewPost'],
            [
                'post' => $this,
                'link' => Url::to(['/guestbook/admin/a/view', 'id' => $this->primaryKey], true)
            ]
        );
    }

    public function notifyUser()
    {
        $settings = Yii::$app->activeModules['guestbook']->settings;

        return Mail::send(
            $this->email,
            $settings['subjectNotifyUser'],
            $settings['templateNotifyUser'],
            [
                'post' => $this,
                'link' => Url::to([$settings['frontendGuestbookRoute']], true)
            ]
        );
    }
}