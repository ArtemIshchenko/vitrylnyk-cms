<?php
use app\modules\article\api\Article;
use app\modules\page\api\Page;
use yii\helpers\Html;

$page = Page::get('page-catalog-rasteniy');

$this->title = $page->seo('title', $page->model->title);
$this->registerMetaTag(['name'=>'description', 'content'=>$page->seo('description')]);
$this->registerMetaTag(['name'=>'keywords', 'content'=>$page->seo('keywords')]);
//$this->params['breadcrumbs'][] = $page->model->title;

?>

<div class="row">
	<div class="col-md-3" style="font-size: 14px;">
		<?= $this->render('_menu', ['cat' => $cat]) ?>
	</div>
	<div class="col-md-9">
		<h1 class="text-center"><?= $page->seo('h1', $page->title) ?></h1>
		<?= Article::renderTable($cat, 'html') ?>
	</div>
</div>