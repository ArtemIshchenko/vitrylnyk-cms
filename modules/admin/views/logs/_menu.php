<?php
use yii\helpers\Url;

$action = $this->context->action->id;
?>
<ul class="nav nav-pills">
    <li <?= ($action==='index') ? 'class="active"' : '' ?>><a href="<?= Url::to(['/admin/logs']) ?>"><?= Yii::t('app', 'Увійти') ?></a></li>
</ul>
<br/>
