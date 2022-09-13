<?php
namespace app\modules\news;

class News extends \app\components\Module
{
    public $settings = [
        'enableThumb' => true,
        'enablePhotos' => true,
        'enableShort' => true,
        'shortMaxLength' => 256,
        'enableTags' => true
    ];

    public static $installConfig = [
        'title' => [
            'en' => 'News',
            'ru' => 'Новости',
						'uk' => 'Новини',
        ],
        'icon' => 'bullhorn',
        'pos' => 70,
    ];
		public static $routes = [
				/*['pattern' => 'news/<action:\w+>/<slug:[\w-]+>',
					'route' => 'news/news/<action>',
					'defaults' => ['action' => 'index', 'slug' => '']
				],*/
				'news' => 'news/news/index',
				'news/view/<slug:[\w-]+>' => 'news/news/view',
    ];
}