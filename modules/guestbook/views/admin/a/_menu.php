<?php
use yii\helpers\Url;

$action = $this->context->action->id;
$module = $this->context->module->id;

$backTo = null;
$indexUrl = Url::to(['/'.$module.'/admin']);
$noanswerUrl = Url::to(['/'.$module.'/admin/a/noanswer']);

if($action === 'view')
{
    $returnUrl = $this->context->getReturnUrl(['/'.$module.'/admin']);

    if(strpos($returnUrl, 'noanswer') !== false){
        $backTo = 'noanswer';
        $noanswerUrl = $returnUrl;
    } else {
        $backTo = 'index';
        $indexUrl = $returnUrl;
    }
}
?>
<ul class="nav nav-pills">
    <li <?= ($action === 'index') ? 'class="active"' : '' ?>>
        <a href="<?= $indexUrl ?>">
            <?php if($backTo === 'index') : ?>
                <i class="glyphicon glyphicon-chevron-left font-12"></i>
            <?php endif; ?>
            <?= Yii::t('app', 'Всі') ?>
        </a>
    </li>
    <li <?= ($action === 'noanswer') ? 'class="active"' : '' ?>>
        <a href="<?= $noanswerUrl ?>">
            <?php if($backTo === 'noanswer') : ?>
                <i class="glyphicon glyphicon-chevron-left font-12"></i>
            <?php endif; ?>
            <?= Yii::t('guestbook', 'Без відповіді') ?>
            <?php if($this->context->noAnswer > 0) : ?>
                <span class="badge"><?= $this->context->noAnswer ?></span>
            <?php endif; ?>
        </a>
    </li>
    <li class="pull-right">
        <?php if($action === 'view') : ?>
            <a href="<?= Url::to(['/'.$module.'/admin/a/setnew', 'id' => Yii::$app->request->get('id')]) ?>" class="text-warning"><span class="glyphicon glyphicon-eye-close"></span> <?= Yii::t('guestbook', 'Помітити як новий') ?></a>
        <?php else : ?>
            <a href="<?= Url::to(['/'.$module.'/admin/a/viewall']) ?>" class="text-warning"><span class="glyphicon glyphicon-eye-open"></span> <?= Yii::t('guestbook', 'Помітити всі як переглянуті') ?></a>
        <?php endif; ?>
    </li>
</ul>
<br/>
