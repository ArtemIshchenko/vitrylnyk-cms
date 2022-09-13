<?php
use app\modules\catalog\api\Catalog;
use app\modules\page\api\Page;
use yii\helpers\Html;

$page = Page::get('page-articles');

$this->title = $page->seo('title', $page->model->title);
$this->params['breadcrumbs'][] = $page->model->title;

?>
<h1><?= $page->seo('h1', $page->title) ?></h1>

	<table class="table table-striped table-bordered table-hover">
    <?php $i = 0;
		foreach($list as $item) {
						if($i == 0) {
							echo '<tr class="info">';
						foreach($item as $key => $value) {
								echo '<th>' . $key . '</th>';
						}
						echo '</tr>';
						}
						echo '<tr>';
						foreach($item as $key => $value) {
							echo '<td>' . $value . '</td>';
						}
						echo '</tr>';
						++$i;
					}
		?>
	</table>
