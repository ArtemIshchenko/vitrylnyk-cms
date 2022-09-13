<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\widgets\Menu;
use app\modules\menu\api\Menu as ItemMenu;
$asset = \app\assets\AppAsset::register($this);
$this->params['asset'] = $asset;
?>
<?php $this->beginContent('@app/views/userlayouts/base.php'); ?>
<div id="wrapper">
    <header>
		<div class="container-fluide"></div>
		<div class="container">
			<div class="row first">
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
													'items' => ItemMenu::menuList(),
													/*'items' => [
                            ['label' => 'Каталог рослин', 'url' => ['/article/catalog/index']],
                            ['label' => 'Сбір', 'url' => ['/catalog/sbor/index']],
                            ['label' => 'Рецепти', 'url' => ['/article/receptes/index']],
														['label' => 'Указатель', 'url' => ['/article/ukazatel/index']],
                            ['label' => 'Новини', 'url' => ['/news/news/index']],
														['label' => 'Литература', 'url' => ['/article/libs/index']],
                        ],*/
                    ]); ?>
          </div>		
        </nav>
			</div>
		</div>
    </header>
    <main>
		<div class="container">
				<div class="row">
					<?php if($this->context->id != 'site') : ?>

							<?= Breadcrumbs::widget([
									'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
							])?>
					<?php endif; ?>
				</div>
				<div class="row">					
					<div class="col-md-9" style="font-size: 16px;">
						<div class="content">
							<?= $content ?>
						</div>
					</div>
					<div class="col-xs-7 col-sm-5 col-md-3">
						<div class="sidebar">
						<div class="panel panel-primary" style="margin-bottom: 0px;">
							<div class="panel-heading">
								Полезная информация
							</div>
							<div class="panel-body">
								<?php
									$cat = \app\modules\article\api\Article::cat('poleznaya-informaciya');
									$articles = \app\modules\article\api\Article::last(10, ['category_id'=>$cat->id]);
									foreach($articles as $item) : ?>
										<div class="row">
											<div class="col-xs-12">
												<?php $img = $item->thumb(65, 60) ?>
												<?php $img = $img ? Html::img($img, ['style'=>"float: left; padding-right: 8px;"]) : '' ?>
												<?= Html::a($img . ' <b>' . $item->title . '</b> ' . $item->short . '<div style="clear: both;"></div>', ['/article/articles/view', 'slug' => $item->slug], ['class'=>'thumbnail', 'style'=>"color: #000; margin-bottom: 10px;"]) ?>
											</div>
										</div>
									<?php endforeach; ?>
							</div>
						</div>
					</div>
				</div>
				</div>
				<?php
				//Yii::$app->params['v'] = ItemMenu::menuList();
				if(isset(Yii::$app->params['v'])) {
										if(is_array(Yii::$app->params['v']) || is_object(Yii::$app->params['v'])) {
											echo '<pre>';
											print_r(Yii::$app->params['v']);
											echo '</pre>';
										}
										else
											echo Yii::$app->params['v'];
										}
										?>
										
			</div>
    </main>
		<footer>
			<div class="container-fluide"></div>
		</footer>
</div>
<?php $this->endContent(); ?>
