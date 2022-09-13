<?php
use app\modules\article\api\Article;
use app\modules\page\api\Page;
use app\modules\carousel\api\Carousel;
use yii\helpers\Html;

$page = Page::get('page-index');

$this->title = $page->seo('title', $page->model->title);
?>
<div class="row">
	<div class="col-md-12">
		<?= Carousel::widget(830, 450) ?>
	</div>
</div>
	<?php foreach ($cat->items() as $i => $item) : ?>
					<?php if($i%3==0) : ?>
						<div class="row">
					<?php endif; ?>
						<div class="col-md-4">
							<div class="thumbnail">
						<?= Html::a(Html::img($item->image, ['alt'=>$item->title]), ['view', 'slug' => $item->slug]) ?>
							<div class="caption">
								<h4><?= $item->title ?></h4>
								<p><?= $item->short ?></p>
								<p><?= Html::a('Читать далее', ['view', 'slug' => $item->slug], ['class'=>'btn btn-primary']) ?></p>
							</div>
							</div>
						</div>
						<?php if($i%3==2 || $i==count($cat->items())-1) : ?>
						</div>
						<?php endif; ?>
	<?php endforeach; ?>