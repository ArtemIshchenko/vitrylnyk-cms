<?php
use yii\helpers\Html;
use app\modules\catalog\assets\FieldsAsset;
use app\modules\catalog\models\Category;

$this->title = Yii::t('catalog', 'Поля категоріі');

$this->registerAssetBundle(FieldsAsset::className());

$this->registerJs('
var fieldTemplate = \'\
    <tr>\
        <td>'. Html::input('text', null, null, ['class' => 'form-control field-name']) .'</td>\
        <td>'. Html::input('text', null, null, ['class' => 'form-control field-title']) .'</td>\
        <td>\
            <select class="form-control field-type">'.str_replace("\n", "", Html::renderSelectOptions('', Category::$fieldTypes)).'</select>\
        </td>\
        <td><textarea class="form-control field-options" placeholder="'.Yii::t('catalog', 'Наберіть опціі, використовуючи кому, як роздільник').'" style="display: none;"></textarea></td>\
        <td class="text-right">\
            <div class="btn-group btn-group-sm" role="group">\
                <a href="#" class="btn btn-default move-up" title="'. Yii::t('app', 'Перемістити вгору') .'"><span class="glyphicon glyphicon-arrow-up"></span></a>\
                <a href="#" class="btn btn-default move-down" title="'. Yii::t('app', 'Перемістити вниз') .'"><span class="glyphicon glyphicon-arrow-down"></span></a>\
                <a href="#" class="btn btn-default color-red delete-field" title="'. Yii::t('app', 'Видалити пункт') .'"><span class="glyphicon glyphicon-remove"></span></a>\
            </div>\
        </td>\
    </tr>\';
', \yii\web\View::POS_HEAD);

?>
<?= $this->render('@app/views/category/_menu') ?>
<?= $this->render('_submenu', ['model' => $model]) ?>
<br>

<?= Html::button('<i class="glyphicon glyphicon-plus font-12"></i> '.Yii::t('catalog', 'Додати поле'), ['class' => 'btn btn-default', 'id' => 'addField']) ?>

<table id="categoryFields" class="table table-hover">
    <thead>
        <th>Им'я</th>
        <th><?= Yii::t('app', 'Заголовок') ?></th>
        <th><?= Yii::t('catalog', 'Тип') ?></th>
        <th><?= Yii::t('catalog', 'Опціі') ?></th>
        <th width="120"></th>
    </thead>
    <tbody>
    <?php foreach($model->fields as $field) : ?>
        <tr>
            <td><?= Html::input('text', null, $field->name, ['class' => 'form-control field-name']) ?></td>
            <td><?= Html::input('text', null, $field->title, ['class' => 'form-control field-title']) ?></td>
            <td>
                <select class="form-control field-type">
                    <?= Html::renderSelectOptions($field->type, Category::$fieldTypes) ?>
                </select>
            </td>
            <td>
                <textarea class="form-control field-options" placeholder="<?= Yii::t('catalog', 'Наберіть опціі, використовуючи кому, як роздільник') ?>" <?= !$field->options ? 'style="display: none;"' : '' ?> ><?= is_array($field->options) ? implode(',', $field->options) : '' ?></textarea>
            </td>
            <td class="text-right">
                <div class="btn-group btn-group-sm" role="group">
                    <a href="#" class="btn btn-default move-up" title="<?= Yii::t('app', 'Перемістити вгору') ?>"><span class="glyphicon glyphicon-arrow-up"></span></a>
                    <a href="#" class="btn btn-default move-down" title="<?= Yii::t('app', 'Перемістити вниз') ?>"><span class="glyphicon glyphicon-arrow-down"></span></a>
                    <a href="#" class="btn btn-default color-red delete-field" title="<?= Yii::t('app', 'Видалити пункт') ?>"><span class="glyphicon glyphicon-remove"></span></a>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?= Html::button('<i class="glyphicon glyphicon-ok"></i> '.Yii::t('catalog', 'Зберегти поля'), ['class' => 'btn btn-primary', 'id' => 'saveCategoryBtn']) ?>
