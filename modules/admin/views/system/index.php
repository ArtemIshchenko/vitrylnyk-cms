<?php
use app\modules\admin\models\Setting;
use yii\helpers\Url;

$this->title = Yii::t('app', 'Система');
?>

<h4><?= Yii::t('app', 'Поточна версія') ?>: <b><?= Setting::get('version') ?></b>
    <?php if(\app\components\Application::VERSION > floatval(Setting::get('version'))) : ?>
        <a href="<?= Url::to(['/admin/system/update']) ?>" class="btn btn-success"><?= Yii::t('app', 'Оновити') ?></a>
    <?php endif; ?>
</h4>

<br>

<p>
    <a href="<?= Url::to(['/admin/system/flush-cache']) ?>" class="btn btn-default"><i class="glyphicon glyphicon-flash"></i> <?= Yii::t('app', 'Очістити кеш') ?></a>
</p>

<br>

<p>
    <a href="<?= Url::to(['/admin/system/clear-assets']) ?>" class="btn btn-default"><i class="glyphicon glyphicon-trash"></i> <?= Yii::t('app', 'Очістити assets') ?></a>
</p>