<?php
namespace app\modules\menu\api;

use Yii;

use app\modules\menu\models\Item;

/**
 * Menu module API
 * @package yii\easyii\modules\menu\api
 *
 */

class Menu extends \app\components\API
{
    public function api_menuList()
    {
			return Item::menuList();
    }
}