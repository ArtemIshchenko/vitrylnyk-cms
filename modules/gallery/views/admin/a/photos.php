<?php
use app\widgets\Photos;

$this->title = $model->title;
?>

<?= $this->render('@app/views/category/_menu') ?>

<?= Photos::widget(['model' => $model])?>