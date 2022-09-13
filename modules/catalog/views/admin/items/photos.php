<?php
use app\widgets\Photos;

$this->title = Yii::t('app', 'Фото') . ' ' . $model->title;
?>

<?= $this->render('_menu', ['category' => $model->category]) ?>
<?= $this->render('_submenu', ['model' => $model]) ?>

<?= Photos::widget(['model' => $model])?>