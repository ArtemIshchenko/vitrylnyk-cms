<?php
namespace app\modules\admin\models;

use Yii;
use yii\base\Model;

class InstallForm extends Model
{
    const RETURN_URL_KEY = 'install_root_password';
    const ROOT_PASSWORD_KEY = 'install_success_return';

    public $root_password;
    public $recaptcha_key;
    public $recaptcha_secret;
    public $robot_email;
    public $admin_email;

    public function rules()
    {
        return [
            ['root_password', 'required'],
            ['root_password', 'string', 'min' => 6],
            [['recaptcha_key', 'recaptcha_secret'], 'string'],
            [['robot_email', 'admin_email'], 'email'],
            [['root_password', 'recaptcha_key', 'recaptcha_secret', 'robot_email', 'admin_email'], 'trim'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'root_password' => Yii::t('app/install', 'Root password'),
            'admin_email' => Yii::t('app/install', 'Admin E-mail'),
            'robot_email' => Yii::t('app/install', 'Robot E-mail')
        ];
    }
}