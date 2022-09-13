<?php
use yii\helpers\Url;

$action = $this->context->action->id;
$module = $this->context->module->id;
?>

<ul class="nav nav-tabs">
    <li <?= ($action === 'edit') ? 'class="active"' : '' ?>><a href="<?= Url::to(['/'.$module.'/admin/items/edit', 'id' => $model->primaryKey]) ?>"><?= Yii::t('app', 'Редагувати') ?></a></li>
    <li <?= ($action === 'photos') ? 'class="active"' : '' ?>><a href="<?= Url::to(['/'.$module.'/admin/items/photos', 'id' => $model->primaryKey]) ?>"><span class="glyphicon glyphicon-camera"></span> <?= Yii::t('app', 'Фото') ?></a></li>
</ul>
<br>