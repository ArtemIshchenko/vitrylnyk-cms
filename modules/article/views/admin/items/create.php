<?php
$this->title = Yii::t('article', 'Створити статтю');
?>
<?= $this->render('_menu', ['category' => $category]) ?>
<?= $this->render('_form', ['model' => $model]) ?>