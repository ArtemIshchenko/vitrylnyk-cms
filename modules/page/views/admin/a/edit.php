<?php
$this->title = Yii::t('page', 'Редагувати сторінку');
?>
<?= $this->render('_menu') ?>
<?= $this->render('_form', ['model' => $model]) ?>