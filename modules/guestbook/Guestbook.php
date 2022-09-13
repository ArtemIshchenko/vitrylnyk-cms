<?php
namespace app\modules\guestbook;

class Guestbook extends \app\components\Module
{
    public $settings = [
        'enableTitle' => false,
        'enableEmail' => true,
        'preModerate' => false,
        'enableCaptcha' => false,
        'mailAdminOnNewPost' => true,
        'subjectOnNewPost' => 'New message in the guestbook.',
        'templateOnNewPost' => '@app/modules/guestbook/mail/en/new_post',
        'frontendGuestbookRoute' => '/guestbook',
        'subjectNotifyUser' => 'Your post in the guestbook answered',
        'templateNotifyUser' => '@app/modules/guestbook/mail/en/notify_user'
    ];

    public static $installConfig = [
        'title' => [
            'en' => 'Guestbook',
            'ru' => 'Гостевая книга',
						'uk' => 'Гостьова книга',
        ],
        'icon' => 'book',
        'pos' => 80,
    ];
		public static $routes = [
				['pattern' => 'guestbook/<action:\w+>/<slug:[\w-]+>',
					'route' => 'guestbook/guestbook/<action>',
					'defaults' => ['action' => 'index', 'slug' => '']
				],
    ];
}