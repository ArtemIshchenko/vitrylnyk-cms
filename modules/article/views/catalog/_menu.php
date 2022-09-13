<?php
use yii\helpers\Html;
use app\modules\article\api\Article;
$isDivOpened = false;
?>
<div class="panel-group" id="navigation" role="tablist" aria-multiselectable="true">
	<?php foreach ($items=Article::renderTable($cat, 'list') as $item) : ?>
				<?php if(count($item)==1 && $item[0]!='') : ?>
						<?php if(Article::isActive($item, Yii::$app->request->get('slug'))) {
							$active = ' active';
							$in = ' in';
						}
						else
							$active = $in = '';
						?>
						<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingOne<?= $item[0] ?>">
							<h4 class="panel-title">
						<?= Html::a($item[0] . ' <span class="caret"></span>', '#collapseOne'.$item[0],
						['class'=>'list-group-item' . $active, 'data-toggle'=>'collapse', 'aria-expanded'=>'false',
						'data-parent'=>'#navigation', 'aria-controls'=>'collapseOne'.$item[0],
						'style'=>'text-align: center;']) ?>
							</h4>
						</div>
						
						<div class="submenu panel-collapse collapse<?= $in ?>" id="collapseOne<?= $item[0] ?>" role="tabpanel" aria-labelledby="headingOne<?= $item[0] ?>">
						<div class="panel-body">
						<?php $isDivOpened = true; ?>
				<?php elseif($item[0]!='') : ?>
						<?php $active = strpos(Yii::$app->request->pathInfo, $item[1]) ? ' active' : '' ?>
						<?= Html::a($item[0], ['catalog/view', 'slug' => $item[1]], ['class' => 'list-group-item' . $active]) ?>
				<?php else : ?>
						<?php if($isDivOpened) : ?>
							</div></div></div>
							<?php $isDivOpened = false; ?>
						<?php endif; ?>
				<?php endif; ?>
	<?php endforeach; ?>
	<?php if($isDivOpened) : ?>
					</div></div></div>
					<?php $isDivOpened = false; ?>
	<?php endif; ?>
</div>