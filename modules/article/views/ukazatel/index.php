<?php
use app\modules\article\api\Article;
use app\modules\page\api\Page;
use yii\helpers\Html;

$page = Page::get('ukazatel');

$this->title = $page->seo('title', $page->model->title);
$this->params['breadcrumbs'][] = $page->model->title;

?>

<h1><?= $page->seo('h1', $page->title) ?></h1>
<br/>
<?php if($cat) : ?>
<?= Article::renderTable($cat, true) ?>
<?php else : ?>
<div class="alert alert-warning" role="alert">Раздел находится в разработке</div>
<?php endif; ?>