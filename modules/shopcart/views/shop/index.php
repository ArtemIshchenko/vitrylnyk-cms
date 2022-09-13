<?php
use app\modules\catalog\api\Catalog;
use app\modules\file\api\File;
use app\modules\page\api\Page;
use yii\helpers\Html;

$page = Page::get('page-shop');
$this->title = $page->seo('title', $page->model->title);
$this->params['breadcrumbs'][] = $page->model->title;

?>


<div class="row">
    <div class="col-md-8">
        <h1>
            <?= $page->seo('h1', $page->title) ?>
						<?php if($file=File::get('price-list')) : ?>
            <a class="btn btn-success" href="<?= $file->file ?>"><i class="glyphicon glyphicon-save"></i> Завантажити прайс</a>
						<?php endif; ?>
        </h1>
        <br/>
        <ul>
            <?= Catalog::renderTree() ?>
        </ul>
    </div>
    <div class="col-md-4">
        <?= $this->render('_search_form', ['text' => '']) ?>

        <h4>Last items</h4>
        <?php foreach(Catalog::last(3) as $item) : ?>
            <p>
                <?= Html::img($item->thumb(30)) ?>
                <?= Html::a($item->title, ['shop/view', 'slug' => $item->slug]) ?><br/>
                <span class="label label-warning"><?= $item->price ?>$</span>
            </p>
        <?php endforeach; ?>
    </div>
</div>

