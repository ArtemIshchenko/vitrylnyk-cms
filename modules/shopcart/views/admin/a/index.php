<?php
use app\modules\shopcart\models\News;
use app\modules\shopcart\models\Order;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('shopcart', 'Замовлення');

$module = $this->context->module->id;
?>

<?= $this->render('_menu') ?>

<?php if($data->count > 0) : ?>
    <table class="table table-hover">
        <thead>
            <tr>
                <th width="100">#</th>
                <th><?= Yii::t('app', 'Ім\'я') ?></th>
                <th><?= Yii::t('shopcart', 'Адреса') ?></th>
                <th width="100"><?= Yii::t('shopcart', 'Вартість') ?></th>
                <th width="150"><?= Yii::t('app', 'Дата') ?></th>
                <th width="90"><?= Yii::t('app', 'Статус') ?></th>
                <th width="90"></th>
            </tr>
        </thead>
        <tbody>
    <?php foreach($data->models as $item) : ?>
            <tr>
                <td>
                    <?= Html::a($item->primaryKey, ['/shopcart/admin/a/view', 'id' => $item->primaryKey]) ?>
                    <?php if($item->new) : ?>
                        <span class="label label-warning">NEW</span>
                    <?php endif; ?>
                </td>
                <td><?= $item->name ?></td>
                <td><?= $item->address ?></td>
                <td><?= $item->cost ?></td>
                <td><?= Yii::$app->formatter->asDatetime($item->time, 'short') ?></td>
                <td><?= Order::statusName($item->status) ?></td>
                <td class="control">
                    <div class="btn-group btn-group-sm" role="group">
                        <a href="<?= Url::to(['/'.$module.'/admin/a/view', 'id' => $item->primaryKey]) ?>" class="btn btn-default" title="<?= Yii::t('shopcart', 'Переглянути') ?>"><span class="glyphicon glyphicon-eye-open"></span></a>
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