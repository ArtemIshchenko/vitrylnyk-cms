<?php
use yii\helpers\Url;

$action = $this->context->action->id;
$module = $this->context->module->id;

$historyUrl = Url::to(['/'.$module.'/admin/a/history']);
if($action === 'view'){
    $returnUrl = $this->context->getReturnUrl();
    if(strpos($returnUrl, 'history') !== false){
        $historyUrl = $returnUrl;
    }
}
?>
<ul class="nav nav-pills">
    <li <?= ($action === 'index') ? 'class="active"' : '' ?>>
        <a href="<?= Url::to(['/'.$module.'/admin']) ?>"><?= Yii::t('subscribe', 'Підписчики') ?></a>
    </li>
    <li <?= ($action === 'create') ? 'class="active"' : '' ?>>
        <a href="<?= Url::to(['/'.$module.'/admin/a/create']) ?>">
        <?= Yii::t('subscribe', 'Створити розсилку') ?>
        </a>
    </li>
    <li <?= ($action === 'history') ? 'class="active"' : '' ?>>
        <a href="<?= $historyUrl ?>">
            <?php if($action === 'view') : ?>
                <i class="glyphicon glyphicon-chevron-left font-12"></i>
            <?php endif; ?>
            <?= Yii::t('subscribe', 'Історія') ?>
        </a>
    </li>
</ul>
<br/>
