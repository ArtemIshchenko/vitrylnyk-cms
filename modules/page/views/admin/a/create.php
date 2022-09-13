<?php
$this->title = Yii::t('page', 'Створити сторінку');
?>
<?= $this->render('_menu') ?>
<?= $this->render('_form', ['model' => $model]) ?>