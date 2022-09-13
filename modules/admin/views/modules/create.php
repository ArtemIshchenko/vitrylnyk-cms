<?php
$this->title = Yii::t('app', 'Створити модуль');
?>
<?= $this->render('_menu') ?>
<?= $this->render('_form', ['model' => $model]) ?>