<?php
$this->title = Yii::t('news', 'Створення новини');
?>
<?= $this->render('_menu') ?>
<?= $this->render('_form', ['model' => $model]) ?>