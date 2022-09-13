<?php
use app\modules\article\api\Article;
use app\modules\page\api\Page;
use app\modules\carousel\api\Carousel;
use yii\helpers\Html;

$page = Page::get('page-index');

$this->title = $page->seo('title', $page->model->title);
?>
<?= Carousel::widget(1140, 520) ?>
	<?php foreach ($cat->items() as $i => $item) : ?>
					<?php if($i%3==0) : ?>
						<div class="row">
					<?php endif; ?>
						<div class="col-md-4" style="text-align: center;">
						<?= '<br>' . Html::a(Html::img($item->image) .	'<br>' . $item->title, ['view', 'slug' => $item->slug], ['style'=>"color: #000;"]) ?>
						</div>
						<?php if($i%3==2 || $i==count($cat->items())-1) : ?>
						</div>
						<?php endif; ?>
	<?php endforeach; ?>