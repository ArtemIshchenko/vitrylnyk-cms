<?php
namespace app\modules\faq;

use Yii;

class Faq extends \app\components\Module
{
    public static $installConfig = [
        'title' => [
            'en' => 'FAQ',
            'ru' => 'Вопросы и ответы',
						'uk' => 'Питання та відповіді',
        ],
        'icon' => 'question-sign',
        'pos' => 45,
    ];
		public static $routes = [
				['pattern' => 'faq/<action:\w+>/<slug:[\w-]+>',
					'route' => 'faq/faq/<action>',
					'defaults' => ['action' => 'index', 'slug' => '']
				],
    ];
}