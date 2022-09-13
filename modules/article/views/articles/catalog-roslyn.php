<?php
use yii\helpers\Html;
use yii\helpers\Url;
use app\modules\article\api\Article;

$this->title = $cat->seo('title', $cat->model->title);
$this->params['breadcrumbs'][] = ['label' => 'Статті', 'url' => ['/article/index']];
$this->params['breadcrumbs'][] = $cat->model->title;
?>
<h1><?= $cat->seo('h1', $cat->title) ?></h1>
<br/>

<?= Article::renderTable($cat) ?>