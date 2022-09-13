<?php
namespace app\assets;

class EmptyAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@app/media';
    public $css = [
        'css/empty.css',
    ];
    public $depends = [
        'yii\bootstrap\BootstrapAsset',
    ];
}
