<?php
namespace app\modules\page;

use Yii;

class Page extends \app\components\Module
{
    public static $installConfig = [
        'title' => [
            'en' => 'Pages',
            'ru' => 'Страницы',
						'uk' => 'Сторінки',
        ],
        'icon' => 'file',
        'pos' => 3,
    ];
}