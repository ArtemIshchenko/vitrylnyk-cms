<?php
use app\modules\catalog\models\Item;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('catalog', 'Каталог');

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
            <th><?= Yii::t('app', 'Ім\'я') ?></th>
            <th width="100"><?= Yii::t('app', 'Статус') ?></th>
            <th width="120"></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($model->items as $item) : ?>
            <tr data-id="<?= $item->primaryKey ?>">
                <?php if(IS_ROOT) : ?>
                    <td><?= $item->primaryKey ?></td>
                <?php endif; ?>
                <td><a href="<?= Url::to(['/'.$module.'/admin/items/edit', 'id' => $item->primaryKey]) ?>"><?= $item->title ?></a></td>
                <td class="status">
                    <?= Html::checkbox('', $item->status == Item::STATUS_ON, [
                        'class' => 'switch',
                        'data-id' => $item->primaryKey,
                        'data-link' => Url::to(['/'.$module.'/admin/items']),
                    ]) ?>
                </td>
                <td class="text-right">
                    <div class="btn-group btn-group-sm" role="group">
                        <a href="<?= Url::to(['/'.$module.'/admin/items/up', 'id' => $item->primaryKey, 'category_id' => $model->primaryKey]) ?>" class="btn btn-default move-up" title="<?= Yii::t('app', 'Вгору') ?>"><span class="glyphicon glyphicon-arrow-up"></span></a>
                        <a href="<?= Url::to(['/'.$module.'/admin/items/down', 'id' => $item->primaryKey, 'category_id' => $model->primaryKey]) ?>" class="btn btn-default move-down" title="<?= Yii::t('app', 'Вниз') ?>"><span class="glyphicon glyphicon-arrow-down"></span></a>
                        <a href="<?= Url::to(['/'.$module.'/admin/items/delete', 'id' => $item->primaryKey]) ?>" class="btn btn-default confirm-delete" title="<?= Yii::t('app', 'Delete item') ?>"><span class="glyphicon glyphicon-remove"></span></a>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php else : ?>
    <p><?= Yii::t('app', 'Записи не знайдені') ?></p>
<?php endif; ?>