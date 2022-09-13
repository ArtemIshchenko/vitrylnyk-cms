<?php

namespace app\modules\article;

class Article extends \app\components\Module
{
		public $settings = [
        'categoryThumb' => true,
        'articleThumb' => true,
        'enablePhotos' => true,

        'enableShort' => true,
        'shortMaxLength' => 255,
        'enableTags' => true,

        'itemsInFolder' => false,
    ];
		public static $installConfig = [
        'title' => [
            'en' => 'Articles',
            'ru' => 'Статьи',
						'uk' => 'Статті',
        ],
        'icon' => 'pencil',
        'pos' => 1,
    ];
		public static $routes = [
				'<controller:\w+>' => 'article/<controller>/index',
				'<controller:\w+>/<slug:[\w-]+>' => 'article/<controller>/view',
				'articles/<slug:[\w-]+>' => 'article/articles/view',
    ];
}
