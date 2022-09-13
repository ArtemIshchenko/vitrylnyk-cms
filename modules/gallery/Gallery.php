<?php
namespace app\modules\gallery;

class Gallery extends \app\components\Module
{
    public $settings = [
        'categoryThumb' => true,
        'itemsInFolder' => false,
    ];

    public static $installConfig = [
        'title' => [
            'en' => 'Photo Gallery',
            'ru' => 'Фотогалерея',
						'uk' => 'Фотогалерея',
        ],
        'icon' => 'camera',
        'pos' => 90,
    ];
		public static $routes = [
				['pattern' => 'gallery/<action:\w+>/<slug:[\w-]+>',
					'route' => 'gallery/gallery/<action>',
					'defaults' => ['action' => 'index', 'slug' => '']
				],
    ];
}