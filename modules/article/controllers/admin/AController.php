<?php
namespace app\modules\article\controllers\admin;

use app\components\CategoryController;

class AController extends CategoryController
{
    /** @var string  */
    public $categoryClass = 'app\modules\article\models\Category';
}