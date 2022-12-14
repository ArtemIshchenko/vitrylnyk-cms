<?php
use app\modules\news\api\News;
use app\modules\page\api\Page;
use yii\helpers\Html;
use yii\helpers\Url;

$page = Page::get('page-news');

$this->title = $page->seo('title', $page->model->title);
$this->params['breadcrumbs'][] = $page->model->title;
?>
<h1><?= $page->seo('h1', $page->title) ?></h1>
<br/>

<?php foreach($news as $item) : ?>
    <div class="row">
        <div class="col-md-3">
            <?= Html::img($item->thumb(160, 120)) ?>
        </div>
        <div class="col-md-9">
            <?= Html::a($item->title, ['news/view', 'slug' => $item->slug]) ?>
            <div class="small-muted"><?= $item->date ?></div>
            <p class="text-justify"><?= $item->short ?></p>
            <p>
                <?php foreach($item->tags as $tag) : ?>
                    <a href="<?= Url::to(['/news', 'tag' => $tag]) ?>" class="label label-info"><?= $tag ?></a>
                <?php endforeach; ?>
            </p>
        </div>
    </div>
    <br>
<?php endforeach; ?>

<?= News::pages() ?>
