<?php
$this->title = Yii::t('faq', 'Редагувати запис');
?>
<?= $this->render('_menu') ?>
<?= $this->render('_form', ['model' => $model]) ?>