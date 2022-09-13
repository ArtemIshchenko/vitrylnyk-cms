<?php
$this->title = Yii::t('file', 'Редагувати файл');
?>
<?= $this->render('_menu') ?>
<?= $this->render('_form', ['model' => $model]) ?>