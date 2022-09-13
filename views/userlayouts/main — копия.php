<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\widgets\Menu;
$asset = \app\assets\AppAsset::register($this);
$this->params['asset'] = $asset;
?>
<?php $this->beginContent('@app/views/userlayouts/base.php'); ?>
<div id="wrapper" class="container">
    <header>
			<div class="row">
				<?= Html::img($asset->baseUrl . '/img/logo_header5.png', ['width' => '100%', 'height' => '140px']) ?>
			</div>
			<div class="row">
        <nav class="navbar navbar-default" role="navigation">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-menu">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
             </button>
             <!-- <a class="navbar-brand" href="<?//= Url::home() ?>"></a> -->
					</div>
          <div class="collapse navbar-collapse" id="navbar-menu">
            <?= Menu::widget([
													'options' => ['class' => 'nav navbar-nav'],
													'items' => [
                            ['label' => 'Каталог рослин', 'url' => ['/article/catalog/index']],
                            ['label' => 'Сбір', 'url' => ['/catalog/sbor/index']],
                            ['label' => 'Рецепти', 'url' => ['/article/receptes/index']],
                            ['label' => 'Gallery', 'url' => ['/gallery/index']],
                            ['label' => 'Guestbook', 'url' => ['/guestbook/index']],
                            ['label' => 'FAQ', 'url' => ['/faq/index']],
                            ['label' => 'Contact', 'url' => ['/contact/index']],
                        ],
                    ]); ?>
          </div>		
        </nav>
			</div>	
    </header>
    <main>
        <?php if($this->context->id != 'site') : ?>
            <br/>
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ])?>
        <?php endif; ?>
				<div class="row">
					<div class="col-xs-6 col-sm-8 col-md-9">
					<?= $content ?>
					</div>
					<div class="col-xs-6 col-sm-4 col-md-3">
						<div class="panel panel-default">
							<div class="panel-heading">
								Новини
							</div>
							<div class="panel-body">
								<?php
									$news = \app\modules\news\api\News::last(5);
									foreach($news as $item) : ?>
										<div class="row">
											<div class="col-xs-4 col-lg-3">
												<?= Html::img($item->thumb(60, 50)) ?>
											</div>
											<div class="col-xs-8 col-lg-9">
												<?= Html::a($item->title, ['news/view', 'slug' => $item->slug]) ?>
											</div>
										</div><br>
									<?php endforeach; ?>
							</div>
						</div>
					</div>
				</div>
        <div class="push"></div>
				<?php if(isset(Yii::$app->params['v'])) {
										if(is_array(Yii::$app->params['v']) || is_object(Yii::$app->params['v'])) {
											echo '<pre>';
											print_r(Yii::$app->params['v']);
											echo '</pre>';
										}
										else
											echo Yii::$app->params['v'];
										}
										?>
			
    </main>
</div>
<footer>
  <div class="container footer-content">
		<div class="row">
			<?= Html::img($asset->baseUrl . '/img/logo_footer5.png', ['width' => '100%', 'height' => '95px']) ?>
		</div>
    <div class="row">
      <div class="col-md-2"></div>
    </div>
    <div class="col-md-4 text-right"></div>
  </div>
</footer>
<?php $this->endContent(); ?>
