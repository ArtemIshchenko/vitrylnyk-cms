<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\widgets\SeoForm;
?>
<?php $form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'options' => ['enctype' => 'multipart/form-data', 'class' => 'model-form']
]); ?>
<?= $form->field($model, 'title') ?>
<?= $form->field($model, 'file')->fileInput() ?>
<?php if(!$model->isNewRecord) : ?>
    <div><a href="<?= $model->file ?>" target="_blank"><?= basename($model->file) ?></a> (<?= Yii::$app->formatter->asShortSize($model->size, 2) ?>)</div>
    <br>
<?php endif; ?>

<?php if(IS_ROOT) : ?>
    <?= $form->field($model, 'slug') ?>
    <?= SeoForm::widget(['model' => $model]) ?>
<?php endif; ?>

<?= Html::submitButton(Yii::t('app', 'Зберегти'), ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>