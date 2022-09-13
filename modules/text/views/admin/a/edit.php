<?php
$this->title = Yii::t('text', 'Оновити текст');
?>
<?= $this->render('_menu') ?>
<?= $this->render('_form', ['model' => $model]) ?>