<?php
use app\helpers\Image;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\widgets\SeoForm;

$class = $this->context->categoryClass;
$settings = $this->context->module->settings;
?>
<?php $form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'options' => ['enctype' => 'multipart/form-data']
]); ?>
<?= $form->field($model, 'title') ?>

<?php if(!empty($parent)) : ?>
    <div class="form-group field-category-title required">
        <label for="category-parent" class="control-label"><?= Yii::t('app', 'Батьківська категорія') ?></label>
        <select class="form-control" id="category-parent" name="parent">
            <option value="" class="smooth"><?= Yii::t('app', 'Ні') ?></option>
            <?php foreach($class::tree() as $cat) : ?>
                <option
                    value="<?= $cat->id ?>"
                    <?php if($parent == $cat->id) echo 'SELECTED' ?>
                    style="padding-left: <?= $cat->depth*20 ?>px;"
                ><?= $cat->title ?></option>
            <?php endforeach; ?>
        </select>
    </div>
<?php endif; ?>

<?php if($settings['categoryThumb']) : ?>
    <?php if($model->image) : ?>
        <img src="<?= Image::thumb($model->image, 240) ?>">
        <a href="<?= Url::to(['/'.$this->context->module->id.'/admin/a/clear-image', 'id' => $model->primaryKey]) ?>" class="text-danger confirm-delete" title="<?= Yii::t('app', 'Видалити малюнок')?>"><?= Yii::t('app', 'Видалити малюнок')?></a>
    <?php endif; ?>
    <?= $form->field($model, 'image')->fileInput() ?>
<?php endif; ?>

<?php if(IS_ROOT) : ?>
    <?= $form->field($model, 'slug') ?>
    <?= SeoForm::widget(['model' => $model]) ?>
<?php endif; ?>

<?= Html::submitButton(Yii::t('app', 'Зберегти'), ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>