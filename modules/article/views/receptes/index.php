<?php
use app\modules\article\api\Article;
use app\modules\page\api\Page;
use yii\helpers\Html;
use yii\web\View;

$page = Page::get('page-recepty');

$this->title = $page->seo('title', $page->model->title);
$this->registerMetaTag(['name'=>'description', 'content'=>$page->seo('description')]);
$this->registerMetaTag(['name'=>'keywords', 'content'=>$page->seo('keywords')]);

/*$this->registerJs("$(function(){
        $('div.collapse').on('hide.bs.collapse', function () {
					$(this).prev('div').find('span').removeClass().addClass('glyphicon glyphicon-menu-up');
				})
				$('div.collapse').on('show.bs.collapse', function () {
					$(this).prev('div').find('span').removeClass().addClass('glyphicon glyphicon-menu-down');
				})
    });",
View::POS_END);*/
?>
<div class="row">
	<div class="col-md-3" style="font-size: 14px;">
		<?= $this->render('_menu', ['cat' => $cat]) ?>
	</div>
	<div class="col-md-9">
		<?php
			echo $page->text;
		?>
	</div>
</div>
