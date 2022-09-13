<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<?php $form = ActiveForm::begin(['enableAjaxValidation' => true]); ?>
<?= $form->field($model, 'name') ?>
<?= $form->field($model, 'class') ?>
<?= $form->field($model, 'title') ?>
<?= $form->field($model, 'icon') ?>
<?= Html::submitButton(Yii::t('app', 'Зберегти'), ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>