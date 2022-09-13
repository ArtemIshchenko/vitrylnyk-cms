<?php
$this->title = Yii::t('text', 'Створити текст');
?>
<?= $this->render('_menu') ?>
<?= $this->render('_form', ['model' => $model]) ?>