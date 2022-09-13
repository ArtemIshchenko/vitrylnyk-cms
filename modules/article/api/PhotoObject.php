<?php
namespace app\modules\article\api;

use Yii;
use app\components\API;
use yii\helpers\Html;
use yii\helpers\Url;

class PhotoObject extends \app\components\ApiObject
{
    public $image;
    public $description;

    public function box($width, $height){
        $img = Html::img($this->thumb($width, $height));
        $a = Html::a($img, $this->image, [
            'class' => 'easyii-box',
            'rel' => 'article-'.$this->model->item_id,
            'title' => $this->description
        ]);
        return LIVE_EDIT ? API::liveEdit($a, $this->editLink) : $a;
    }

    public function getEditLink(){
        return Url::to(['/article/admin/items/photos', 'id' => $this->model->item_id]).'#photo-'.$this->id;
    }
}