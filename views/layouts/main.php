<?php
use yii\helpers\Html;
use yii\helpers\Url;
use app\assets\AdminAsset;

$asset = AdminAsset::register($this);
$moduleName = $this->context->module->id;
?>
<?php $this->beginPage() ?>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
		<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <?= Html::csrfMetaTags() ?>
    <title><?= Yii::t('app', 'Панель курування') ?> - <?= Html::encode($this->title) ?></title>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
    <link rel="shortcut icon" href="<?= $asset->baseUrl ?>/favicon.ico" type="image/x-icon">
    <link rel="icon" href="<?= $asset->baseUrl ?>/favicon.ico" type="image/x-icon">
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div id="admin-body">
    <div class="container-fluid">
        <div class="wrapper">
            <div class="header">
                <div class="logo">  
                  <div style="padding-left: 25px; padding-top: 3px; text-align: left;">
										<img src="<?= $asset->baseUrl ?>/img/logo_2.png" style="float: left;">
										<div style="display: inline-block; text-align: center; padding-left: 10px;">Vitrylnik CMS</div>
									</div>
                </div>
                <div class="nav">
                    <a href="<?= Url::to(['/']) ?>" class="pull-left"><i class="glyphicon glyphicon-home"></i> <?= Yii::t('app', 'Відкрити сайт') ?></a>
                    <a href="<?= Url::to(['/admin/sign/out']) ?>" class="pull-right"><i class="glyphicon glyphicon-log-out"></i> <?= Yii::t('app', 'Вийти') ?></a>
                </div>
            </div>
            <div class="main">
                <div class="box sidebar">
                    <?php foreach(Yii::$app->activeModules as $module) : ?>
                        <a href="<?= Url::to(["/$module->name/admin"]) ?>" class="menu-item <?= ($moduleName == $module->name ? 'active' : '') ?>">
                            <?php if($module->icon != '') : ?>
                                <i class="glyphicon glyphicon-<?= $module->icon ?>"></i>
                            <?php endif; ?>
                            <?= $module->title ?>
                            <?php if($module->notice > 0) : ?>
                                <span class="badge"><?= $module->notice ?></span>
                            <?php endif; ?>
                        </a>
                    <?php endforeach; ?>
                    <a href="<?= Url::to(['/admin/settings']) ?>" class="menu-item <?= ($this->context->id == 'settings') ? 'active' :'' ?>">
                        <i class="glyphicon glyphicon-cog"></i>
                        <?= Yii::t('app', 'Налаштування') ?>
                    </a>
										<a href="<?= Url::to(['/admin/statistic']) ?>" class="menu-item <?= ($this->context->id == 'statistic') ? 'active' :'' ?>">
                        <i class="glyphicon glyphicon-dashboard"></i>
                        <?= Yii::t('app', 'Статистика') ?>
												<?php if(($countViews = \app\models\Counter::getCountViews()) > 0) : ?>
                                <span class="badge"><?= $countViews ?></span>
                        <?php endif; ?>
                    </a>
                    <?php if(IS_ROOT) : ?>
                        <a href="<?= Url::to(['/admin/modules']) ?>" class="menu-item <?= ($this->context->id == 'modules') ? 'active' :'' ?>">
                            <i class="glyphicon glyphicon-folder-close"></i>
                            <?= Yii::t('app', 'Модулі') ?>
                        </a>
                        <a href="<?= Url::to(['/admin/admins']) ?>" class="menu-item <?= ($this->context->id == 'admins') ? 'active' :'' ?>">
                            <i class="glyphicon glyphicon-user"></i>
                            <?= Yii::t('app', 'Адміністратори') ?>
                        </a>
                        <a href="<?= Url::to(['/admin/system']) ?>" class="menu-item <?= ($this->context->id == 'system') ? 'active' :'' ?>">
                            <i class="glyphicon glyphicon-hdd"></i>
                            <?= Yii::t('app', 'Система') ?>
                        </a>
                        <a href="<?= Url::to(['/admin/logs']) ?>" class="menu-item <?= ($this->context->id == 'logs') ? 'active' :'' ?>">
                            <i class="glyphicon glyphicon-align-justify"></i>
                            <?= Yii::t('app', 'Логи') ?>
                        </a>
                    <?php endif; ?>
                </div>
                <div class="box content">
                    <div class="page-title">
                        <?= $this->title ?>
                    </div>
                    <div class="container-fluid">
                        <?php foreach(Yii::$app->session->getAllFlashes() as $key => $message) : ?>
                            <div class="alert alert-<?= $key ?>"><?= $message ?></div>
                        <?php endforeach; ?>
                        <?= $content ?>
                    </div>
										<?php if(isset(Yii::$app->params['v'])) {
										if(is_array(Yii::$app->params['v']) || is_object(Yii::$app->params['v']))
											print_r(Yii::$app->params['v']);
										else
											echo Yii::$app->params['v'];
										}
										?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>