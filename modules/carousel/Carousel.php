<?php
namespace app\modules\carousel;

class Carousel extends \app\components\Module
{
    public $settings = [
        'enableTitle' => true,
        'enableText' => true,
    ];

    public static $installConfig = [
        'title' => [
            'en' => 'Carousel',
            'ru' => 'Карусель',
						'uk' => 'Карусель',
        ],
        'icon' => 'picture',
        'pos' => 40,
    ];
}