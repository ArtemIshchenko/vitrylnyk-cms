<?php
namespace app\modules\article\api;

use Yii;
use app\components\API;
use app\models\Photo;
use app\modules\article\models\Item;
use yii\helpers\Url;

class ArticleObject extends \app\components\ApiObject
{
    /** @var  string */
    public $slug;

    public $image;

    public $views;

    public $time;

    /** @var  int */
    public $category_id;

    private $_photos;

    public function getTitle(){
        return LIVE_EDIT ? API::liveEdit($this->model->title, $this->editLink) : $this->model->title;
    }

    public function getShort(){
        return LIVE_EDIT ? API::liveEdit($this->model->short, $this->editLink) : $this->model->short;
    }

    public function getText(){
        return LIVE_EDIT ? API::liveEdit($this->model->text, $this->editLink, 'div') : $this->model->text;
    }

    public function getCat(){
        return Article::cats()[$this->category_id];
    }

    public function getTags(){
        return $this->model->tagsArray;
    }

    public function getDate(){
        return Yii::$app->formatter->asDate($this->time);
    }

    public function getPhotos()
    {
        if(!$this->_photos){
            $this->_photos = [];

            foreach(Photo::find()->where(['class' => Item::className(), 'item_id' => $this->id])->sortPos()->all() as $model){
                $this->_photos[] = new PhotoObject($model);
            }
        }
        return $this->_photos;
    }

    public function getEditLink(){
        return Url::to(['/article/admin/items/edit/', 'id' => $this->id]);
    }
}