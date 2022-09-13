<?php
use yii\helpers\Url;

$this->title = Yii::t('page', 'Сторінки');

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
                <th><?= Yii::t('app', 'Заголовок')?></th>
                <?php if(IS_ROOT) : ?>
                    <th><?= Yii::t('app', 'Slug')?></th>
                    <th width="30"></th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
    <?php foreach($data->models as $item) : ?>
            <tr>
                <?php if(IS_ROOT) : ?>
                    <td><?= $item->primaryKey ?></td>
                <?php endif; ?>
                <td><a href="<?= Url::to(['/'.$module.'/admin/a/edit', 'id' => $item->primaryKey]) ?>"><?= $item->title ?></a></td>
                <?php if(IS_ROOT) : ?>
                    <td><?= $item->slug ?></td>
                    <td><a href="<?= Url::to(['/'.$module.'/admin/a/delete', 'id' => $item->primaryKey]) ?>" class="glyphicon glyphicon-remove confirm-delete" title="<?= Yii::t('app', 'Видалити запис')?>"></a></td>
                <?php endif; ?>
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