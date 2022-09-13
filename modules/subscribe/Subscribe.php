<?php
namespace app\modules\subscribe;

class Subscribe extends \app\components\Module
{
    public static $installConfig = [
        'title' => [
            'en' => 'E-mail subscribe',
            'ru' => 'E-mail рассылка',
						'uk' => 'E-mail розсилка',
        ],
        'icon' => 'envelope',
        'pos' => 10,
    ];
}