<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\widgets\Ckeditor;
use app\widgets\SeoForm;
?>
<?php $form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'options' => ['class' => 'model-form']
]); ?>
<?= $form->field($model, 'title') ?>

<?= $form->field($model, 'text')->widget(Ckeditor::className()); ?>

<?php if(IS_ROOT) : ?>
    <?= $form->field($model, 'slug') ?>
    <?= SeoForm::widget(['model' => $model]) ?>
<?php endif; ?>

<?= Html::submitButton(Yii::t('app','Зберегти'), ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>