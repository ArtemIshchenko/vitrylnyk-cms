<?php
$this->title = Yii::t('app', 'Сворити запис');
?>
<?= $this->render('_menu') ?>
<?= $this->render('_form', ['model' => $model]) ?>