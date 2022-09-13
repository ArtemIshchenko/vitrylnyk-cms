<?php
use yii\helpers\Url;

$action = $this->context->action->id;
?>
<ul class="nav nav-pills">
    <li <?= ($action === 'index') ? 'class="active"' : '' ?>>
        <a href="<?= $this->context->getReturnUrl(['/'.$this->context->module->id.'/admin']) ?>">
            <?php if($action != 'index') : ?>
                <i class="glyphicon glyphicon-chevron-left font-12"></i>
            <?php endif; ?>
            <?= Yii::t('app', 'Категорії') ?>
        </a>
    </li>
    <li <?= ($action === 'create') ? 'class="active"' : '' ?>><a href="<?= Url::to(['/'.$this->context->module->id.'/admin/a/create']) ?>"><?= Yii::t('app', 'Створити категорію') ?></a></li>
</ul>
<br/>