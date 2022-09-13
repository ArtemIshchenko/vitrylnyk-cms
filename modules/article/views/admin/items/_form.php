<?php
use app\helpers\Image;
use app\widgets\DateTimePicker;
use app\widgets\TagsInput;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\widgets\Ckeditor;
use app\widgets\SeoForm;

use dosamigos\selectize\Selectize;
use yii\web\JsExpression;

$module = $this->context->module->id;
?>
<?php $form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'options' => ['enctype' => 'multipart/form-data', 'class' => 'model-form']
]); ?>
<?= $form->field($model, 'title') ?>

<?php if($this->context->module->settings['articleThumb']) : ?>
    <?php if($model->image) : ?>
        <img src="<?= Image::thumb($model->image, 240) ?>">
        <a href="<?= Url::to(['/'.$module.'/admin/items/clear-image', 'id' => $model->primaryKey]) ?>" class="text-danger confirm-delete" title="<?= Yii::t('app', 'Видалити малюнок')?>"><?= Yii::t('app', 'Видалити малюнок')?></a>
    <?php endif; ?>
    <?= $form->field($model, 'image')->fileInput() ?>
<?php endif; ?>

<?php if($this->context->module->settings['enableShort']) : ?>
    <?= $form->field($model, 'short')->textarea() ?>
<?php endif; ?>
<?= $form->field($model, 'text')->widget(Ckeditor::className()); ?>
<?= $form->field($model, 'time')->widget(DateTimePicker::className()); ?>
<?php if($this->context->module->settings['enableTags']) : ?>
    <?= $form->field($model, 'tagNames')->widget(TagsInput::className()) ?>
<?php endif; ?>

<?php if(IS_ROOT) : ?>
    <?= $form->field($model, 'slug') ?>
    <?= SeoForm::widget(['model' => $model]) ?>
<?php endif; ?>

<?= Html::submitButton(Yii::t('app', 'Зберегти'), ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>