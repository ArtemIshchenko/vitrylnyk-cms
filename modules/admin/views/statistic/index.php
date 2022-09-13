<?php
use app\models\Counter;
use yii\helpers\Url;

$this->title = Yii::t('app', 'Статистика');
?>
<div class="panel panel-default">
	<div class="panel-body h3 text-center">
		<div class="row">
			<div class="col-md-3">
				Кількість переглядів <span class="label label-primary"><?= Counter::getCount($models) ?></span>
			</div>
			<div class="col-md-3">
				Статус ОК <span class="label label-primary"><?= Counter::getCount($models, Counter::COUT_SUCCESS_RESPONSE) ?></span>
			</div>
			<div class="col-md-3">
				Помилки <span class="label label-warning"><?= Counter::getCount($models, Counter::COUT_UNSUCCESS_RESPONSE) ?></span>
			</div>
			<div class="col-md-3">
				<a class="btn btn-primary" href="<?= Url::to('statistic/delete') ?>" role="button">Скинути лічільники</a>
			</div>
		</div>
	</div>
</div>
<?php if(count($models) > 0) : ?>
    <table class="table table-striped table-bordered">
        <thead>
					<tr>
            <?php if(IS_ROOT) : ?>
              <th width="3%">#</th>
            <?php endif; ?>
						<th><a href="<?= Url::to($route['title']) ?>">
						<?= Yii::t('app', 'Заголовок') ?>
						<?php if(Counter::isPrimarySort($sort, 'title')) : ?>
							<?php if($sort['title'] == Counter::SORT_ASCENDING) : ?>
								<span class="glyphicon glyphicon-sort-by-alphabet"></span>
							<?php else : ?>
								<span class="glyphicon glyphicon-sort-by-alphabet-alt"></span>
							<?php endif; ?>
						<?php endif; ?>
						</a></th>
						<th><a href="<?= Url::to($route['url']) ?>">URL
						<?php if(Counter::isPrimarySort($sort, 'url')) : ?>
							<?php if($sort['url'] == Counter::SORT_ASCENDING) : ?>
								<span class="glyphicon glyphicon-sort-by-alphabet"></span>
							<?php else : ?>
								<span class="glyphicon glyphicon-sort-by-alphabet-alt"></span>
							<?php endif; ?>
						<?php endif; ?>
						</a></th>
						<th width="10%"><a href="<?= Url::to($route['last_time']) ?>">
						<?= Yii::t('app', 'Час') ?>
						<?php if(Counter::isPrimarySort($sort, 'last_time')) : ?>
							<?php if($sort['last_time'] == Counter::SORT_ASCENDING) : ?>
								<span class="glyphicon glyphicon-sort-by-order"></span>
							<?php else : ?>
								<span class="glyphicon glyphicon-sort-by-order-alt"></span>
							<?php endif; ?>
						<?php endif; ?>
						</a></th>
						<th width="10%"><a href="<?= Url::to($route['last_status']) ?>">
						<?= Yii::t('app', 'Статус') ?>
						<?php if(Counter::isPrimarySort($sort, 'last_status')) : ?>
							<?php if($sort['last_status'] == Counter::SORT_ASCENDING) : ?>
								<span class="glyphicon glyphicon-sort-by-alphabet"></span>
							<?php else : ?>
								<span class="glyphicon glyphicon-sort-by-alphabet-alt"></span>
							<?php endif; ?>
						<?php endif; ?>
						</a></th>
						<th width="9%"><a href="<?= Url::to($route['count']) ?>">
						<?= Yii::t('app', 'Лічільник') ?>
						<?php if(Counter::isPrimarySort($sort, 'count')) : ?>
							<?php if($sort['count'] == Counter::SORT_ASCENDING) : ?>
								<span class="glyphicon glyphicon-sort-by-order"></span>
							<?php else : ?>
								<span class="glyphicon glyphicon-sort-by-order-alt"></span>
							<?php endif; ?>
						<?php endif; ?>
						</a></th>
					</tr>
        </thead>
        <tbody>
        <?php foreach($models as $model) : ?>
            <tr>
								<?php if(IS_ROOT) : ?>
                <td><?= $model->primaryKey ?></td>
                <?php endif; ?>
                <td><?= $model->title ?></td>
								<td><?= $model->url ?></td>
								<td><?= $model->date ?></td>
								<td><?= $model->last_status ?></td>
								<td><?= $model->count ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php else : ?>
    <p><?= Yii::t('app', 'Записи не знайдені') ?></p>
<?php endif; ?>