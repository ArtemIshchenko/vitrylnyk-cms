<?php
use yii\helpers\Url;

$this->title = Yii::t('file', 'Файли');

$module = $this->context->module->id;
?>

<?= $this->render('_menu') ?>

<?php if($data->count > 0) : ?>
    <table class="table table-hover">
        <thead>
            <tr>
                <?php if(IS_ROOT) : ?>
                    <th width="50">#</th>
                <?php endif; ?>
                <th><?= Yii::t('app', 'Заголовок') ?></th>
                <th width="100"><?= Yii::t('file', 'Розмір') ?></th>
                <th width="130"><?= Yii::t('file', 'Завантаження') ?></th>
                <th width="150"><?= Yii::t('app', 'Дата') ?></th>
                <th width="120"></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($data->models as $item) : ?>
            <tr data-id="<?= $item->primaryKey ?>">
                <?php if(IS_ROOT) : ?>
                    <td><?= $item->primaryKey ?></td>
                <?php endif; ?>
                <td><a href="<?= Url::to(['/'.$module.'/admin/a/edit', 'id' => $item->primaryKey]) ?>"><?= $item->title ?></a></td>
                <td><?= Yii::$app->formatter->asShortSize($item->size, 2) ?></td>
                <td><?= $item->downloads ?></td>
                <td><?= Yii::$app->formatter->asDatetime($item->time, 'short') ?></td>
                <td class="control">
                    <div class="btn-group btn-group-sm" role="group">
                        <a href="<?= Url::to(['/'.$module.'/admin/a/up', 'id' => $item->primaryKey]) ?>" class="btn btn-default move-up" title="<?= Yii::t('app', 'Вгору') ?>"><span class="glyphicon glyphicon-arrow-up"></span></a>
                        <a href="<?= Url::to(['/'.$module.'/admin/a/down', 'id' => $item->primaryKey]) ?>" class="btn btn-default move-down" title="<?= Yii::t('app', 'Вниз') ?>"><span class="glyphicon glyphicon-arrow-down"></span></a>
                        <a href="<?= Url::to(['/'.$module.'/admin/a/delete', 'id' => $item->primaryKey]) ?>" class="btn btn-default confirm-delete" title="<?= Yii::t('app', 'Видалити запис') ?>"><span class="glyphicon glyphicon-remove"></span></a>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?= yii\widgets\LinkPager::widget([
        'pagination' => $data->pagination
    ]) ?>
<?php else : ?>
    <p><?= Yii::t('app', 'Записи не знайдені') ?></p>
<?php endif; ?>