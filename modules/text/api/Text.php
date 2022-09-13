<?php
namespace app\modules\text\api;

use Yii;
use app\components\API;
use app\helpers\Data;
use yii\helpers\Url;
use app\modules\text\models\Text as TextModel;
use yii\helpers\Html;

/**
 * Text module API
 * @package yii\easyii\modules\text\api
 *
 * @method static get(mixed $id_slug) Get text block by id or slug
 */
class Text extends API
{
    private $_texts = [];

    public function init()
    {
        parent::init();

        $this->_texts = Data::cache(TextModel::CACHE_KEY, 3600, function(){
            return TextModel::find()->asArray()->all();
        });
    }

    public function api_get($id_slug)
    {
        if(($text = $this->findText($id_slug)) === null){
            return $this->notFound($id_slug);
        }
        return LIVE_EDIT ? API::liveEdit($text['text'], Url::to(['/text/admin/a/edit/', 'id' => $text['id']])) : $text['text'];
    }

    private function findText($id_slug)
    {
        foreach ($this->_texts as $item) {
            if($item['slug'] == $id_slug || $item['id'] == $id_slug){
                return $item;
            }
        }
        return null;
    }

    private function notFound($id_slug)
    {
        $text = '';

        if(!Yii::$app->user->isGuest && preg_match(TextModel::$SLUG_PATTERN, $id_slug)){
            $text = Html::a(Yii::t('text/api', 'Створити текст'), ['/text/admin/a/create', 'slug' => $id_slug], ['target' => '_blank']);
        }

        return $text;
    }
}