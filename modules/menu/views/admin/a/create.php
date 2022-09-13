<?php
$this->title = Yii::t('menu', 'Додати категорію');
?>
<?= $this->render('_menu') ?>
<?= $this->render('_form', ['model' => $model, 'parent' => $parent]) ?>