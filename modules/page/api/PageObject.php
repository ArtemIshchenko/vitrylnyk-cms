<?php
namespace app\modules\page\api;

use Yii;
use app\components\API;
use yii\helpers\Html;
use yii\helpers\Url;

class PageObject extends \app\components\ApiObject
{
    public $slug;

    public function getTitle(){
        if($this->model->isNewRecord){
					if(!Yii::$app->user->isGuest)
            return $this->createLink;
        } else {
            return LIVE_EDIT ? API::liveEdit($this->model->title, $this->editLink) : $this->model->title;
        }
    }

    public function getText(){
        if($this->model->isNewRecord){
            return $this->createLink;
        } else {
            return LIVE_EDIT ? API::liveEdit($this->model->text, $this->editLink, 'div') : $this->model->text;
        }
    }

    public function getEditLink(){
        return Url::to(['/page/admin/a/edit/', 'id' => $this->id]);
    }

    public function getCreateLink(){
        return Html::a(Yii::t('page/api', 'Створити сторінку'), ['/page/admin/a/create', 'slug' => $this->slug], ['target' => '_blank']);
    }
}