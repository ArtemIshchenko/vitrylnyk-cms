<?php
namespace app\assets;

class PhotosAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@app/assets/photos';
    public $css = [
        'photos.css',
    ];
    public $js = [
        'photos.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
