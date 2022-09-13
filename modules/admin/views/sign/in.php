<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$asset = \app\assets\EmptyAsset::register($this);
$this->title = Yii::t('app', 'Реєстрація');
?>
<div class="container">
    <div id="wrapper" class="col-md-4 col-md-offset-4 vertical-align-parent">
        <div class="vertical-align-child">
            <div class="panel">
                <div class="panel-heading text-center">
                    <?= Yii::t('app', 'Реєстрація') ?>
                </div>
                <div class="panel-body">
                    <?php $form = ActiveForm::begin([
                        'fieldConfig' => [
                            'template' => "{label}\n{input}\n{hint}\n{error}"
                        ]
                    ])
                    ?>
                        <?= $form->field($model, 'username') ?>
                        <?= $form->field($model, 'password')->passwordInput() ?>
												<?= $form->field($model, 'rememberMe')->checkbox() ?>
                        <?=Html::submitButton(Yii::t('app', 'Увійти'), ['class'=>'btn btn-lg btn-primary btn-block']) ?>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
            <div class="text-center">
                <a class="logo" href="http://dolphincms.ua" target="_blank" title="DolphinCMS homepage">
                    <img src="<?= $asset->baseUrl ?>/img/logo_2.png">
										<div style="display: inline-block; text-align: center;">Vitrilnyk<br>CMS</div>
                </a>
            </div>
        </div>
    </div>
</div>
