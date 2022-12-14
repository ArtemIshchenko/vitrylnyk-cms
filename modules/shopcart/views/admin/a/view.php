<?php
use app\modules\shopcart\models\Order;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('shopcart', 'Замовлення') . ' #' . $order->primaryKey;
$this->registerCss('.shopcart-view dt{margin-bottom: 10px;}');

$states = Order::states();
unset($states[Order::STATUS_BLANK]);

$module = $this->context->module->id;

$this->registerJs('
var oldStatus = '.$order->status.';
$("#order-status").change(function(){
    if($(this).val() != oldStatus){
        $("#notify-user").slideDown();
    } else {
        $("#notify-user").slideUp();
    }
});
');
?>
<?= $this->render('_menu') ?>

<?= Html::beginForm() ?>
<dl class="dl-horizontal shopcart-view">
    <?php if($order->status != Order::STATUS_BLANK) : ?>
        <dt><?= Yii::t('app', 'Статус') ?></dt>
        <dd>
            <div class="form-group">
                <?= Html::dropDownList('status', $order->status, $states, ['id' => 'order-status']) ?>
            </div>
        </dd>
    <?php endif; ?>

    <dt><?= Yii::t('app', 'Ім\'я') ?></dt>
    <dd><?= $order->name ?></dd>

    <dt><?= Yii::t('shopcart', 'Адреса') ?></dt>
    <dd><?= $order->address ?></dd>

    <?php if($this->context->module->settings['enablePhone']) : ?>
        <dt><?= Yii::t('shopcart', 'Телефон') ?></dt>
        <dd><?= $order->phone ?></dd>
    <?php endif; ?>

    <?php if($this->context->module->settings['enableEmail']) : ?>
        <dt><?= Yii::t('app', 'E-mail') ?></dt>
        <dd><?= $order->email ?></dd>
    <?php endif; ?>

    <dt><?= Yii::t('app', 'Дата') ?></dt>
    <dd><?= Yii::$app->formatter->asDatetime($order->time, 'medium') ?></dd>

    <dt>IP</dt>
    <dd><?= $order->ip ?> <a href="//freegeoip.net/?q=<?= $order->ip ?>" class="label label-info" target="_blank">info</a></dd>

    <dt><?= Yii::t('shopcart', 'Коментар') ?></dt>
    <dd><?= nl2br($order->comment) ?></dd>

    <dt><?= Yii::t('shopcart', 'Помітка адміністратора') ?></dt>
    <dd>
        <div class="form-group">
            <?= Html::textarea('remark', $order->remark, ['class' => 'form-control']) ?>
        </div>
        <?php if($order->email) : ?>
            <div class="checkbox" id="notify-user" style="display: none;">
                <label>
                    <?= Html::checkbox('notify', true, ['uncheck' => 0]) ?> <?= Yii::t('shopcart', 'Повідомлення замовника по E-mail') ?>
                </label>
            </div>
        <?php endif; ?>
        <?= Html::submitButton(Yii::t('app', 'Зберегти'), ['class' => 'btn btn-primary']) ?>
    </dd>
</dl>
<?= Html::endForm() ?>
<hr>
<h3><?= Yii::t('shopcart', 'Пункти') ?></h3>
<table class="table table-bordered">
    <thead>
        <th><?= Yii::t('app', 'Заголовок') ?></th>
        <th><?= Yii::t('shopcart', 'Опціі') ?></th>
        <th width="80"><?= Yii::t('shopcart', 'Кількість') ?></th>
        <th width="80"><?= Yii::t('shopcart', 'Знижка') ?></th>
        <th width="150"><?= Yii::t('shopcart', 'Вартість') ?></th>
        <th width="30"></th>
    </thead>
    <tbody>
        <?php foreach($goods as $good) : ?>
            <tr>
                <td><?= Html::a($good->item->title, ['/catalog/admin/items/edit', 'id' => $good->item->primaryKey]) ?></td>
                <td><?= $good->options ?></td>
                <td><?= $good->count ?></td>
                <td><?= $good->discount ?></td>
                <td>
                    <?php if($good->discount) : ?>
                        <b><?= round($good->price * (1 - $good->discount / 100)) ?></b>
                        <strike><small class="smooth"><?= $good->price ?></small></strike>
                    <?php else : ?>
                        <b><?= $good->price ?></b>
                    <?php endif; ?>
                </td>
                <td><a href="<?= Url::to(['/'.$module.'/admin/goods/delete', 'id' => $good->primaryKey]) ?>" class="glyphicon glyphicon-remove confirm-delete" title="<?= Yii::t('app', 'Видалити запис') ?>"></a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<h2 class="text-right"><small><?= Yii::t('shopcart', 'Разом') ?>:</small> <?= $order->cost ?></h2>
