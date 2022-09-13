<?php
$this->title = Yii::t('app', 'Редагувати запис');
?>
<?= $this->render('_menu') ?>
<?= $this->render('_form', ['model' => $model]) ?>