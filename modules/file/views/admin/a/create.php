<?php
$this->title = Yii::t('file', 'Створити файл');
?>
<?= $this->render('_menu') ?>
<?= $this->render('_form', ['model' => $model]) ?>