<?php
use app\modules\article\api\Article;
use app\modules\page\api\Page;
use yii\helpers\Html;

$page = Page::get('page-articles');

$this->title = $page->seo('title', $page->model->title);
$this->params['breadcrumbs'][] = $page->model->title;
$this->registerMetaTag(['name'=>'description', 'content'=>$page->seo('description')]);
$this->registerMetaTag(['name'=>'keywords', 'content'=>$page->seo('keywords')]);

?>
<!--<h1><?//= $page->seo('h1', $page->title) ?></h1>-->
<br>
<!--<div class="row">-->
  <?php foreach ($cat->items() as $i => $item) : ?>
					<?php if(($i+1)%3==0 || $i==0) : ?>
						<div class="row">
					<?php endif; ?>
						<div class="col-md-4" style="text-align: center;">
						<?= Html::a(Html::img($item->image) .	'<br>' . $item->title . 'asd', ['view', 'slug' => $item->slug])  . '<br><br><br>';?>
						</div>
						<?php if(($i+1)==6 || ($i+1)==3) : ?>
						</div>
						<?php endif; ?>
	<?php endforeach; ?>
</div>
