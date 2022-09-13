<?php
use app\modules\article\models\Item;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('article', 'Статті');

$module = $this->context->module->id;
?>
<?= $this->render('_menu', ['category' => $model]) ?>

<?php if(count($model->items)) : ?>
    <table class="table table-hover">
        <thead>
        <tr>
            <?php if(IS_ROOT) : ?>
                <th width="50">#</th>
            <?php endif; ?>
            <th><?= Yii::t('app', 'Заговолок') ?></th>
						<th width="120"><?= Yii::t('app', 'Переглядів') ?></th>
            <th width="100"><?= Yii::t('app', 'Статус') ?></th>
            <th width="120"></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($model->getItems()->sortDate()->all() as $item) : ?>
            <tr data-id="<?= $item->primaryKey ?>">
                <?php if(IS_ROOT) : ?>
                    <td><?= $item->primaryKey ?></td>
                <?php endif; ?>
                <td><a href="<?= Url::to(['/'.$module.'/admin/items/edit', 'id' => $item->primaryKey]) ?>"><?= $item->title ?></a></td>
								<td><?= $item->views ?></td>
                <td class="status">
                    <?= Html::checkbox('', $item->status == Item::STATUS_ON, [
                        'class' => 'switch',
                        'data-id' => $item->primaryKey,
                        'data-link' => Url::to(['/'.$module.'/admin/items']),
                    ]) ?>
                </td>
                <td class="text-right">
                    <div class="btn-group btn-group-sm" role="group">
                        <a href="<?= Url::to(['/'.$module.'/admin/items/up', 'id' => $item->primaryKey, 'category_id' => $model->primaryKey]) ?>" class="btn btn-default move-up" title="<?= Yii::t('app', 'Перемістити вгору') ?>"><span class="glyphicon glyphicon-arrow-up"></span></a>
                        <a href="<?= Url::to(['/'.$module.'/admin/items/down', 'id' => $item->primaryKey, 'category_id' => $model->primaryKey]) ?>" class="btn btn-default move-down" title="<?= Yii::t('app', 'Перемістити вниз') ?>"><span class="glyphicon glyphicon-arrow-down"></span></a>
                        <a href="<?= Url::to(['/'.$module.'/admin/items/delete', 'id' => $item->primaryKey]) ?>" class="btn btn-default confirm-delete" title="<?= Yii::t('app', 'Видалити пункт') ?>"><span class="glyphicon glyphicon-remove"></span></a>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php else : ?>
    <p><?= Yii::t('app', 'Записи не знадені') ?></p>
<?php endif; ?>