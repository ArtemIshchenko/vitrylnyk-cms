<?php
use app\modules\faq\api\Faq;
use app\modules\page\api\Page;

$page = Page::get('page-faq');

$this->title = $page->seo('title', $page->model->title);
$this->params['breadcrumbs'][] = $page->model->title;
?>
<h1><?= $page->seo('h1', $page->title) ?></h1>
<br/>

<?php foreach(Faq::items() as $item) : ?>
    <p><b>Питання: </b><?= $item->question ?></p>
    <blockquote><b>Відповідь: </b><?= $item->answer ?></blockquote>
<?php endforeach; ?>