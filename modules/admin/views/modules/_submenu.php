<?php
use yii\helpers\Url;

$action = $this->context->action->id;
?>

<ul class="nav nav-tabs">
    <li <?= ($action === 'edit') ? 'class="active"' : '' ?>><a href="<?= Url::to(['/admin/modules/edit/', 'id' => $model->primaryKey]) ?>"> <?= Yii::t('app', 'Основне') ?></a></li>
    <li <?= ($action === 'settings') ? 'class="active"' : '' ?>><a href="<?= Url::to(['/admin/modules/settings/', 'id' => $model->primaryKey]) ?>"><i class="glyphicon glyphicon-cog"></i> <?= Yii::t('app', 'Додатково') ?></a></li>
</ul>
<br>