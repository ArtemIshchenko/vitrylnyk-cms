<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\widgets\Ckeditor;
?>
<?php $form = ActiveForm::begin([
    'options' => ['class' => 'model-form']
]); ?>
<?= $form->field($model, 'question')->widget(Ckeditor::className()); ?>
<?= $form->field($model, 'answer')->widget(Ckeditor::className()); ?>

<?= Html::submitButton(Yii::t('app','Зберегти'), ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>