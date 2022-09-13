<?php
use yii\helpers\Html;
?>
<div class="list-group" id="navigation" role="tablist" aria-multiselectable="true">
			<?php foreach ($cat->model->getChildren()->where(['and', ['status' => app\components\CategoryModel::STATUS_ON], ['not', ['slug' => 'recepty-main']]])->all() as $child) : ?>
						<?php foreach ($items=$child->getItems()->where(['status' => app\components\CategoryModel::STATUS_ON])->all() as $item) {
										if(strpos(Yii::$app->request->pathInfo, $item->slug)) {
											$active = ' active';
											break;
										}
										else
											$active = '';
									}
						?>
					<?= Html::a($child->title . ' <span class="caret"></span>', '#collapseOne'.$child->id, ['class'=>'list-group-item' . $active, 'data-toggle'=>'collapse', 'aria-expanded'=>'true', 'data-parent'=>'#navigation', 'aria-controls'=>'collapseOne']) ?>
					<div class="submenu panel-collapse collapse in" id="collapseOne<?= $child->id ?>">
						<?php foreach ($items as $item) {
										$active = strpos(Yii::$app->request->pathInfo, $item->slug) ? ' active' : '';
										echo Html::a($item->title, ['receptes/view', 'slug' => $item->slug], ['class' => 'list-group-item' . $active]);
									}
						?>
					</div>
			<?php endforeach; ?>
</div>