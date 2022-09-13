<?php
use app\modules\article\api\Article;
use app\modules\page\api\Page;
use yii\helpers\Html;

$this->title = $article->seo('title', $article->model->title);

?>

<h1><?= $article->seo('h1', $article->title) ?></h1>

<?= $article->text ?>
<small class="text-muted"><i class="glyphicon glyphicon-eye-open"></i> <?= $article->views ?></small>