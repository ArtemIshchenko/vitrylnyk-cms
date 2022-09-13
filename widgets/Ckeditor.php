<?php
namespace app\widgets;

use Yii;
use yii\widgets\InputWidget;
use yii\helpers\Html;
use app\assets\CkeditorAsset;

class Ckeditor extends InputWidget
{
    public function init()
    {
        CkeditorAsset::register($this->getView());
				$this->options = ['id'=>$this->attribute];
    }

    public function run()
    {
        echo Html::activeTextarea($this->model, $this->attribute, $this->options);
				echo Html::script("CKEDITOR.replace({$this->attribute},
													{
														language: 'uk',
														extraAllowedContent: 'dl(text-justify); dt dd'
													}
													);");
    }
}