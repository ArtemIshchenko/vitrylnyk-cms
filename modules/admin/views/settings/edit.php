<?php
$this->title = Yii::t('app', 'Редагувати налаштування');
?>
<?= $this->render('_menu') ?>
<?= $this->render('_form', ['model' => $model]) ?>