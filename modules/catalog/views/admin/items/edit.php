<?php
$this->title = Yii::t('app', 'Редагувати'). ' ' .$model->title;
?>
<?= $this->render('_menu', ['category' => $model->category]) ?>
<?= $this->render('_submenu', ['model' => $model]) ?>

<?= $this->render('_form', ['model' => $model, 'dataForm' => $dataForm]) ?>
