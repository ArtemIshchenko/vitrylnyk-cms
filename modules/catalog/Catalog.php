<?php
namespace app\modules\catalog;

class Catalog extends \app\components\Module
{
    public $settings = [
        'categoryThumb' => true,
        'itemsInFolder' => false,

        'itemThumb' => true,
        'itemPhotos' => true,
        'itemDescription' => true,
        'itemSale' => true,
    ];

    public static $installConfig = [
        'title' => [
            'en' => 'Catalog',
            'ru' => 'Каталог',
						'uk' => 'Каталог',
        ],
        'icon' => 'list-alt',
        'pos' => 2,
    ];
		public static $routes = [
				/*['pattern' => 'article/<action:\w+>/<slug:[\w-]+>',
					'route' => 'article/articles/<action>',
					'defaults' => ['action' => 'index', 'slug' => '']
				],
				['pattern' => 'catalog/<l:[\w]+>',
					'route' => 'article/catalog/index',
					'defaults' => ['l' => '']
				],*/
				'sbor' => 'catalog/sbor/index',
    ];
}