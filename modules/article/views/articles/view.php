<?php
use app\modules\article\api\Article;
use yii\helpers\Url;
use yii\helpers\Html;

$this->title = $article->seo('title', $article->model->title);
$this->registerMetaTag(['name'=>'description', 'content'=>$article->seo('description')]);
$this->registerMetaTag(['name'=>'keywords', 'content'=>$article->seo('keywords')]);
?>
<h1><?= $article->seo('h1', $article->title) ?></h1>

<?= Html::img($article->thumb(210, 200), ['alt'=>$article->title, 'style'=>"float: left; padding-right: 15px;"]) . $article->text ?>

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

<small class="text-muted"><i class="glyphicon glyphicon-eye-open"></i> <?= $article->views ?></small>
<div style="clear: both;"></div>