<?php
namespace app\modules\shopcart;

class Shopcart extends \app\components\Module
{
    public $settings = [
        'mailAdminOnNewOrder' => true,
        'subjectOnNewOrder' => 'New order',
        'templateOnNewOrder' => '@app/modules/shop/mail/en/new_order',
        'subjectNotifyUser' => 'Your order status changed',
        'templateNotifyUser' => '@app/modules/shop/mail/en/notify_user',
        'frontendShopcartRoute' => '/shop/order',
        'enablePhone' => true,
        'enableEmail' => true
    ];

    public static $installConfig = [
        'title' => [
            'en' => 'Orders',
            'ru' => 'Заказы',
						'uk' => 'Замовлення',
        ],
        'icon' => 'shopping-cart',
        'pos' => 120,
    ];
		public static $routes = [
				['pattern' => 'shop/<action:\w+>/<slug:[\w-]+>',
					'route' => 'shopcart/shop/<action>',
					'defaults' => ['action' => 'index', 'slug' => '']
				],
				['pattern' => 'shopcart/<action:\w+>/<id:\d+>',
					'route' => 'shopcart/shopcart/<action>',
					'defaults' => ['action' => 'index', 'id' => '']
				],
    ];
}