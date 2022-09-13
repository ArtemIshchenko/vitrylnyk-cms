<?php
namespace app\modules\faq\api;

use Yii;
use app\helpers\Data;
use app\modules\faq\models\Faq as FaqModel;


/**
 * FAQ module API
 * @package yii\easyii\modules\faq\api
 *
 * @method static array items() list of all FAQ as FaqObject objects
 */

class Faq extends \app\components\API
{
    public function api_items()
    {
        return Data::cache(FaqModel::CACHE_KEY, 3600, function(){
            $items = [];
            foreach(FaqModel::find()->select(['id', 'question', 'answer'])->status(FaqModel::STATUS_ON)->sortPos()->all() as $item){
                $items[] = new FaqObject($item);
            }
            return $items;
        });
    }
}