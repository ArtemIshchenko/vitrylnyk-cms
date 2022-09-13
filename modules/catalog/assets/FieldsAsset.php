<?php
namespace app\modules\catalog\assets;

class FieldsAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@app/modules/catalog/media';
    public $css = [
        'css/fields.css',
    ];
    public $js = [
        'js/fields.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
