<?php
$this->title = Yii::t('menu', 'Редагувати категорію');
?>
<?= $this->render('_menu') ?>

<?= $this->render('_form', ['model' => $model]) ?>
