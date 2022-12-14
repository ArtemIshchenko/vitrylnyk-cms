<?php
use yii\helpers\Url;

$action = $this->context->action->id;
?>
<ul class="nav nav-pills">
    <li <?= ($action === 'index') ? 'class="active"' : '' ?>>
        <a href="<?= Url::to(['/admin/modules']) ?>">
            <?php if($action === 'edit' || $action === 'settings') : ?>
                <i class="glyphicon glyphicon-chevron-left font-12"></i>
            <?php endif; ?>
            <?= Yii::t('app', 'Перелік') ?>
        </a>
    </li>
    <li <?= ($action==='create') ? 'class="active"' : '' ?>><a href="<?= Url::to(['/admin/modules/create']) ?>"><?= Yii::t('app', 'Створити') ?></a></li>
</ul>
<br/>
