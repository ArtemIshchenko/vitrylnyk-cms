<?php
namespace app\widgets;

use dosamigos\selectize\Selectize;
use yii\web\JsExpression;

class TagsInput extends Selectize
{
    public $url = ['/admin/tags/list'];
    public $clientOptions = [
				'delimiter' => ',',
        'plugins' => ['remove_button', 'restore_on_backspace'],
				'persist' => false,
				'valueField' => 'name',
        'labelField' => 'name',
        'searchField' => ['name'],
				'create' => true,
    ];
}