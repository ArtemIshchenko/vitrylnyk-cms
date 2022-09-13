<?php
use yii\helpers\Url;

$asset = \app\assets\EmptyAsset::register($this);;

$this->title = Yii::t('app/install', 'Installation completed');
?>
<div class="container">
    <div id="wrapper" class="col-md-6 col-md-offset-3 vertical-align-parent">
        <div class="vertical-align-child">
            <div class="panel">
                <div class="panel-heading text-center">
                    <?= Yii::t('app/install', 'Installation completed') ?>
                </div>
                <div class="panel-body text-center">
                    <a href="<?= Url::to(['/admin']) ?>">Go to control panel</a>
                </div>
            </div>
            <div class="text-center">
                <a class="logo" href="http://cms" target="_blank" title="Delfin CMS homepage">
                    <img src="<?= $asset->baseUrl ?>/img/logo_1.jpg">
										<div style="display: inline-block; text-align: center; padding-top: 10px;">Delfin CMS</div>
                </a>
            </div>
        </div>
    </div>
</div>
