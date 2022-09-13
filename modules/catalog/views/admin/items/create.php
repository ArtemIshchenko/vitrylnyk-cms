<?php
$this->title = Yii::t('catalog', 'Створити пункт');
?>
<?= $this->render('_menu', ['category' => $category]) ?>
<?= $this->render('_form', ['model' => $model, 'dataForm' => $dataForm]) ?>