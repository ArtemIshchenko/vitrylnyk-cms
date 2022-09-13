<?php
$this->title = Yii::t('subscribe', 'Перегляд історії розсилки');
$this->registerCss('.subscribe-view dt{margin-bottom: 10px;}');
?>
<?= $this->render('_menu') ?>

<dl class="dl-horizontal subscribe-view">
    <dt><?= Yii::t('subscribe', 'Тема') ?></dt>
    <dd><?= $model->subject ?></dd>

    <dt><?= Yii::t('app', 'Дата') ?></dt>
    <dd><?= Yii::$app->formatter->asDatetime($model->time, 'medium') ?></dd>

    <dt><?= Yii::t('subscribe', 'Відправлень') ?></dt>
    <dd><?= $model->sent ?></dd>

    <dt><?= Yii::t('subscribe', 'Зміст') ?></dt>
    <dd></dd>
</dl>
<?= $model->body ?>