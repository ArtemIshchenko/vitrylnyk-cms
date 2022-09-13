<?php
namespace app\assets;

use yii\web\AssetBundle;
use yii\web\View;

class CkeditorAsset extends AssetBundle
{
    public $sourcePath = '@app/assets/ckeditor';
    public $depends = ['yii\web\JqueryAsset'];
    public $js = ['ckeditor.js'];
		public $jsOptions = ['position'=>View::POS_HEAD];
}
