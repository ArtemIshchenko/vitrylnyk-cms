<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$class = $this->context->categoryClass;
?>
<?php $form = ActiveForm::begin([
    'enableAjaxValidation' => true,
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

<?= $form->field($model, 'url') ?>

<?= Html::submitButton(Yii::t('app', 'Зберегти'), ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>