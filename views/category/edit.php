<?php
$this->title = Yii::t('app', 'Редагувати категорію');
?>
<?= $this->render('_menu') ?>

<?php if(!empty($this->params['submenu'])) echo $this->render('_submenu', ['model' => $model], $this->context); ?>
<?= $this->render('_form', ['model' => $model]) ?>