<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $model->title;
?>
<?= $this->render('_menu') ?>
<?= $this->render('_submenu', ['model' => $model]) ?>

<?php if(sizeof($model->settings) > 0) : ?>
    <?= Html::beginForm(); ?>
    <?php foreach($model->settings as $key => $value) : ?>
        <?php if(!is_bool($value)) : ?>
        <div class="form-group">
            <label><?= $key; ?></label>
            <?= Html::input('text', 'Settings['.$key.']', $value, ['class' => 'form-control']); ?>
        </div>
        <?php else : ?>
            <div class="checkbox">
                <label>
                    <?= Html::checkbox('Settings['.$key.']', $value, ['uncheck' => 0])?> <?= $key ?>
                </label>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
    <?= Html::submitButton(Yii::t('app', 'Зберегти'), ['class' => 'btn btn-primary']) ?>
    <?php Html::endForm(); ?>
<?php else : ?>
    <?= $model->title ?> <?= Yii::t('app', 'модуль не має налаштувань.') ?>
<?php endif; ?>
<a href="<?= Url::to(['/modules/restore-settings', 'id' => $model->id]) ?>" class="pull-right text-warning"><i class="glyphicon glyphicon-flash"></i> <?= Yii::t('app', 'Відновити налаштування за замовчуванням') ?></a>