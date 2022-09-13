<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\widgets\Ckeditor;
?>
<?php $form = ActiveForm::begin([
    'enableClientValidation' => true
]); ?>
<?= $form->field($model, 'subject') ?>
<?= $form->field($model, 'body')->widget(Ckeditor::className()); ?>
<?= Html::submitButton(Yii::t('app', 'Відправити'), ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>