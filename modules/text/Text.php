<?php
namespace app\modules\text;

class Text extends \app\components\Module
{
    public static $installConfig = [
        'title' => [
            'en' => 'Text blocks',
            'ru' => 'Текстовые блоки',
						'uk' => 'Текстові блоки',
        ],
        'icon' => 'font',
        'pos' => 20,
    ];
}