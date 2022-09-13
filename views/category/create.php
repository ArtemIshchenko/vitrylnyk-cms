<?php
$this->title = Yii::t('app', 'Створити категорію');
?>
<?= $this->render('_menu') ?>
<?= $this->render('_form', ['model' => $model, 'parent' => $parent]) ?>