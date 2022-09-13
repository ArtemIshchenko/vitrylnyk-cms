<?php
use yii\helpers\Url;

$action = $this->context->action->id;
$module = $this->context->module->id;
?>
<?php if(IS_ROOT) : ?>
    <ul class="nav nav-pills">
        <li <?= ($action === 'index') ? 'class="active"' : '' ?>>
            <a href="<?= $this->context->getReturnUrl(['/'.$module.'/admin']) ?>">
                <?php if($action === 'edit') : ?>
                    <i class="glyphicon glyphicon-chevron-left font-12"></i>
                <?php endif; ?>
                <?= Yii::t('app', 'Перелік') ?>
            </a>
        </li>
        <li <?= ($action === 'create') ? 'class="active"' : '' ?>><a href="<?= Url::to(['/'.$module.'/admin/a/create']) ?>"><?= Yii::t('app', 'Створити') ?></a></li>
    </ul>
    <br/>
<?php elseif($action === 'edit') : ?>
    <ul class="nav nav-pills">
        <li>
            <a href="<?= $this->context->getReturnUrl(['/'.$module.'/admin'])?>">
                <i class="glyphicon glyphicon-chevron-left font-12"></i>
                <?= Yii::t('text', 'Тексти') ?>
            </a>
        </li>
    </ul>
    <br/>
<?php endif; ?>