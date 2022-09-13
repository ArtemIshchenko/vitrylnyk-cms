<?php
$this->title = Yii::t('subscribe', 'Створити розсилку');
?>
<?= $this->render('_menu') ?>
<?= $this->render('_form', ['model' => $model]) ?>