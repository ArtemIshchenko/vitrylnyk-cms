<?php
use yii\helpers\Url;

$action = $this->context->action->id;
$module = $this->context->module->id;
?>
<?php if(IS_ROOT) : ?>
    <ul class="nav nav-tabs">
        <li <?= ($action === 'edit') ? 'class="active"' : '' ?>><a href="<?= Url::to(['/'.$module.'/admin/a/edit', 'id' => $model->primaryKey]) ?>"><?= Yii::t('app', 'Редагувати') ?></a></li>
        <li <?= ($action === 'fields') ? 'class="active"' : '' ?>><a href="<?= Url::to(['/'.$module.'/admin/a/fields', 'id' => $model->primaryKey]) ?>"><span class="glyphicon glyphicon-cog"></span> <?= Yii::t('catalog', 'Поля') ?></a></li>
    </ul>
    <br>
<?php endif;?>