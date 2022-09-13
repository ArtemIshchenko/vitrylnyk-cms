<?php
use app\components\CategoryModel;
use app\modules\article\models\Category;
use yii\helpers\Url;

\yii\bootstrap\BootstrapPluginAsset::register($this);

$this->title = Yii::$app->activeModules[$this->context->module->id]->title;

$baseUrl = '/'.$this->context->module->id;
?>

<?= $this->render('_menu') ?>

<?php if(sizeof($categories) > 0) : ?>
    <table class="table table-hover">
        <tbody>
            <?php foreach($categories as $cat) : ?>
                <tr>
                    <td width="50"><?= $cat->pos ?></td>
                    <td style="padding-left:  <?= $cat->depth * 20 ?>px;">
                        <?php if($cat->children) : ?>
                            <i class="caret"></i>
                        <?php endif; ?>
                        <?php if(!$cat->children || !empty(Yii::$app->controller->module->settings['itemsInFolder'])) : ?>
                            <a href="<?= Url::to([$baseUrl . $this->context->viewRoute, 'id' => $cat->id]) ?>" <?= ($cat->status == CategoryModel::STATUS_OFF ? 'class="smooth"' : '') ?>><?= $cat->title ?></a>
                        <?php else : ?>
                            <span <?= ($cat->status == CategoryModel::STATUS_OFF ? 'class="smooth"' : '') ?>><?= $cat->title ?></span>
                        <?php endif; ?>
                    </td>
                    <td width="120" class="text-right">
                        <div class="dropdown actions">
                            <i id="dropdownMenu<?= $cat->id ?>" data-toggle="dropdown" aria-expanded="true" title="<?= Yii::t('app', 'Дії') ?>" class="glyphicon glyphicon-menu-hamburger"></i>
                            <ul class="dropdown-menu dropdown-menu-right" role="menu" aria-labelledby="dropdownMenu<?= $cat->id ?>">
                                <li><a href="<?= Url::to([$baseUrl.'/admin/a/edit', 'id' => $cat->id]) ?>"><i class="glyphicon glyphicon-pencil font-12"></i> <?= Yii::t('app', 'Редагувати') ?></a></li>
                                <li><a href="<?= Url::to([$baseUrl.'/admin/a/create', 'parent' => $cat->id]) ?>"><i class="glyphicon glyphicon-plus font-12"></i> <?= Yii::t('app', 'Додати піддиректорію') ?></a></li>
                                <li role="presentation" class="divider"></li>
                                <li><a href="<?= Url::to([$baseUrl.'/admin/a/up', 'id' => $cat->id]) ?>"><i class="glyphicon glyphicon-arrow-up font-12"></i> <?= Yii::t('app', 'Перемістити вгору') ?></a></li>
                                <li><a href="<?= Url::to([$baseUrl.'/admin/a/down', 'id' => $cat->id]) ?>"><i class="glyphicon glyphicon-arrow-down font-12"></i> <?= Yii::t('app', 'Перемістити вниз') ?></a></li>
                                <li role="presentation" class="divider"></li>
                                <?php if($cat->status == CategoryModel::STATUS_ON) :?>
                                    <li><a href="<?= Url::to([$baseUrl.'/admin/a/off', 'id' => $cat->id]) ?>" title="<?= Yii::t('app', 'Вимкнути') ?>'"><i class="glyphicon glyphicon-eye-close font-12"></i> <?= Yii::t('app', 'Вимкнути') ?></a></li>
                                <?php else : ?>
                                    <li><a href="<?= Url::to([$baseUrl.'/admin/a/on', 'id' => $cat->id]) ?>" title="<?= Yii::t('app', 'Увімкнути') ?>"><i class="glyphicon glyphicon-eye-open font-12"></i> <?= Yii::t('app', 'Увімкнути') ?></a></li>
                                <?php endif; ?>
                                <li><a href="<?= Url::to([$baseUrl.'/admin/a/delete', 'id' => $cat->id]) ?>" class="confirm-delete" data-reload="1" title="<?= Yii::t('app', 'Видалити') ?>"><i class="glyphicon glyphicon-remove font-12"></i> <?= Yii::t('app', 'Видалити') ?></a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
            <?php endforeach;?>
        </tbody>
    </table>
<?php else : ?>
    <p><?= Yii::t('app', 'Записи не знадені') ?></p>
<?php endif; ?>