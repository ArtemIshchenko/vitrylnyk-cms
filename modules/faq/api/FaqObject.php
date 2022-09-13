<?php
namespace app\modules\faq\api;

use app\components\API;
use yii\helpers\Url;

class FaqObject extends \app\components\ApiObject
{
    public function getQuestion(){
        return LIVE_EDIT ? API::liveEdit($this->model->question, $this->editLink) : $this->model->question;
    }

    public function getAnswer(){
        return LIVE_EDIT ? API::liveEdit($this->model->answer, $this->editLink) : $this->model->answer;
    }

    public function  getEditLink(){
        return Url::to(['/faq/admin/a/edit/', 'id' => $this->id]);
    }
}