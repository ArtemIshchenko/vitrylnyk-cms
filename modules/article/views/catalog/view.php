<?php
use app\modules\article\api\Article;
use yii\helpers\Url;
use yii\helpers\Html;

$this->title = $article->seo('title', $article->model->title);
$this->registerMetaTag(['name'=>'description', 'content'=>$article->seo('description')]);
$this->registerMetaTag(['name'=>'keywords', 'content'=>$article->seo('keywords')]);
//$this->params['breadcrumbs'][] = ['label' => 'Каталог', 'url' => ['/catalog']];
//$this->params['breadcrumbs'][] = $article->model->title;
?>
<div class="row">
	<div class="col-md-3" style="font-size: 14px;">
		<?= $this->render('_menu', ['cat' => $cat]) ?>
	</div>
	<div class="col-md-9">
		<h1 class="text-center"><?= $article->seo('h1', $article->title) ?></h1>
		<?php if($article->text) : ?>
			<div class="text-center">
			<?= $article->model->image ? Html::img($article->thumb(615, 500), ['class'=>'img-thumbnail', 'alt'=>$article->title]) : '' ?>
			</div>
			<br/>
			<?= $article->text ?>
		<?php else : ?>
		<p class="bg-warning">Статья находится в разработке</p>
		<?php endif; ?>

		<?php if(count($article->photos)) : ?>
    <div>
      <h4>Фото</h4>
      <?php foreach($article->photos as $photo) : ?>
          <?= $photo->box(100, 100) ?>
      <?php endforeach;?>
      <?php Article::plugin() ?>
		</div>
		<br/>
		<?php endif; ?>
		<p>
    <?php foreach($article->tags as $tag) : ?>
        <a href="<?= Url::to(['articles/cat', 'slug' => $article->cat->slug, 'tag' => $tag]) ?>" class="label label-info"><?= $tag ?></a>
    <?php endforeach; ?>
		</p>
	</div>
</div>