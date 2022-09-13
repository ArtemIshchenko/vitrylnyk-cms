<?php
namespace app\modules\menu\controllers\admin;

use app\components\CategoryController;

class AController extends CategoryController
{
    /** @var string  */
    public $categoryClass = 'app\modules\menu\models\Item';

		/** @var string  */
		public $viewRoute = '/admin/a/edit';
		
		/** @var string  */
    public $createPage = 'create';
		
		/** @var string  */
    public $editPage = 'edit';
}