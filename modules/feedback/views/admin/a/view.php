<?php
use yii\helpers\Html;
use yii\easyii\modules\feedback\models\Feedback;
use yii\widgets\ActiveForm;

$this->title = Yii::t('feedback', 'Перегляд зворотнього зв\'язку');
$this->registerCss('.feedback-view dt{margin-bottom: 10px;}');

if($model->status == Feedback::STATUS_ANSWERED) {
    $this->registerJs('$(".send-answer").click(function(){return confirm("'.Yii::t('feedback', 'Ви впевнені що хочете відправити відповідь?').'");})');
}
?>
<?= $this->render('_menu', ['noanswer' => $model->status == Feedback::STATUS_ANSWERED]) ?>

<dl class="dl-horizontal feedback-view">
    <dt><?= Yii::t('app', 'Ім\'я') ?></dt>
    <dd><?= $model->name ?></dd>

    <dt>E-mail</dt>
    <dd><?= $model->email ?></dd>

    <?php if($this->context->module->settings['enablePhone']) : ?>
    <dt><?= Yii::t('feedback', 'Телефон') ?></dt>
    <dd><?= $model->phone ?></dd>
    <?php endif; ?>

    <?php if($this->context->module->settings['enableTitle']) : ?>
    <dt><?= Yii::t('app', 'Заголовок') ?></dt>
    <dd><?= $model->title ?></dd>
    <?php endif; ?>

    <dt>IP</dt>
    <dd><?= $model->ip ?> <a href="//freegeoip.net/?q=<?= $model->ip ?>" class="label label-info" target="_blank">info</a></dd>

    <dt><?= Yii::t('app', 'Дата') ?></dt>
    <dd><?= Yii::$app->formatter->asDatetime($model->time, 'medium') ?></dd>

    <dt><?= Yii::t('app', 'Текст') ?></dt>
    <dd><?= nl2br($model->text) ?></dd>
</dl>

<hr>
<h2><small><?= Yii::t('feedback', 'Відповідь') ?></small></h2>

<?php $form = ActiveForm::begin() ?>
    <?= $form->field($model, 'answer_subject') ?>
    <?= $form->field($model, 'answer_text')->textarea(['style' => 'height: 250px']) ?>
    <?= Html::submitButton(Yii::t('app', 'Відправити'), ['class' => 'btn btn-success send-answer']) ?>
<?php ActiveForm::end() ?>