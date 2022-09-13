<?php
use yii\helpers\Url;

$action = $this->context->action->id;
$module = $this->context->module->id;
?>
<ul class="nav nav-pills">
    <?php if($action === 'index') : ?>
        <li><a href="<?= Url::to(['/'.$module.'/admin']) ?>"><i class="glyphicon glyphicon-chevron-left font-12"></i> <?= Yii::t('app', 'Категоріі') ?></a></li>
    <?php endif; ?>
    <li <?= ($action === 'index') ? 'class="active"' : '' ?>><a href="<?= Url::to(['/'.$module.'/admin/items', 'id' => $category->primaryKey]) ?>"><?php if($action !== 'index') echo '<i class="glyphicon glyphicon-chevron-left font-12"></i> ' ?><?= $category->title ?></a></li>
    <li <?= ($action === 'create') ? 'class="active"' : '' ?>><a href="<?= Url::to(['/'.$module.'/admin/items/create', 'id' => $category->primaryKey]) ?>"><?= Yii::t('app', 'Додати') ?></a></li>
</ul>
<br/>