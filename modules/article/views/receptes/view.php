<?php
use app\modules\article\api\Article;
use yii\helpers\Url;
use yii\helpers\Html;

$this->title = $article->seo('title', $article->model->title);
$this->registerMetaTag(['name'=>'description', 'content'=>$article->seo('description')]);
$this->registerMetaTag(['name'=>'keywords', 'content'=>$article->seo('keywords')]);
?>

<div class="row">
	<div class="col-md-3" style="font-size: 14px;">
	<?= $this->render('_menu', ['cat' => $cat]) ?>
	</div>
	<div class="col-md-9">
	<h1><?= $article->seo('h1', $article->title) ?></h1>
	<?= ($article->model->image ? Html::img($article->thumb(210, 200), ['style'=>"float: left; padding-right: 15px;"]) : '') . $article->text ?>
	</div>
</div>