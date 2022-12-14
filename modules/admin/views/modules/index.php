<?php
use app\modules\admin\models\Module;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('app', 'Модулі');
?>

<?= $this->render('_menu') ?>

<?php if($data->count > 0) : ?>
    <table class="table table-hover">
        <thead>
        <tr>
            <th width="50">#</th>
            <th><?= Yii::t('app', 'Ідентифікатор') ?></th>
            <th><?= Yii::t('app', 'Им\'я') ?></th>
            <th width="150"><?= Yii::t('app', 'Ярлик') ?></th>
            <th width="100"><?= Yii::t('app', 'Статус') ?></th>
            <th width="150"></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($data->models as $module) : ?>
            <tr data-id=<?= $module->primaryKey ?>>
                <td><?= $module->primaryKey ?></td>
                <td><a href="<?= Url::to(['/admin/modules/edit/', 'id' => $module->primaryKey]) ?>" title="<?= Yii::t('app', 'Edit') ?>"><?= $module->name ?></a></td>
                <td><?= $module->title ?></td>
                <td>
                    <?php if($module->icon) : ?>
                        <span class="glyphicon glyphicon-<?= $module->icon ?>"></span> <?= $module->icon ?>
                    <?php endif; ?>
                </td>
                <td class="status">
                    <?= Html::checkbox('', $module->status == Module::STATUS_ON, [
                        'class' => 'switch',
                        'data-id' => $module->primaryKey,
                        'data-link' => Url::to(['/admin/modules/']),
                        //'data-reload' => '1'
                    ]) ?>
                </td>
                <td class="control">
                    <div class="btn-group btn-group-sm" role="group">
                        <a href="<?= Url::to(['/admin/modules/up/', 'id' => $module->primaryKey]) ?>" class="btn btn-default move-up" title="<?= Yii::t('app', 'Move up') ?>"><span class="glyphicon glyphicon-arrow-up"></span></a>
                        <a href="<?= Url::to(['/admin/modules/down/', 'id' => $module->primaryKey]) ?>" class="btn btn-default move-down" title="<?= Yii::t('app', 'Move down') ?>"><span class="glyphicon glyphicon-arrow-down"></span></a>
                        <a href="<?= Url::to(['/admin/modules/delete/', 'id' => $module->primaryKey]) ?>" class="btn btn-default confirm-delete" title="<?= Yii::t('app', 'Delete item') ?>"><span class="glyphicon glyphicon-remove"></span></a>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
        <?= yii\widgets\LinkPager::widget([
            'pagination' => $data->pagination
        ]) ?>
    </table>
<?php else : ?>
    <p><?= Yii::t('app', 'Записи не знайдені') ?></p>
<?php endif; ?>
