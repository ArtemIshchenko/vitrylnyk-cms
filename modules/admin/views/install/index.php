<?php
$asset = \app\assets\EmptyAsset::register($this);

$this->title = Yii::t('app/install', 'Installation');
?>
<div class="container">
    <div id="wrapper" class="col-md-6 col-md-offset-3 vertical-align-parent">
        <div class="vertical-align-child">
            <div class="panel">
                <div class="panel-heading text-center">
                    <?= Yii::t('app/install', 'Installation') ?>
                </div>
                <div class="panel-body">
                    <?= $this->render('_form', ['model' => $model])?>
                </div>
            </div>
            <div class="text-center">
                <a class="logo" href="http://easyiicms.com" target="_blank" title="EasyiiCMS homepage">
                    <img src="<?= $asset->baseUrl ?>/img/logo_1.jpg">DelfinCMS
                </a>
            </div>
        </div>
    </div>
</div>
