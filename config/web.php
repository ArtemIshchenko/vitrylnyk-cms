<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'app',
    'basePath' => dirname(__DIR__),
		'sourceLanguage' => 'uk-UA',
		'language' => 'uk-UA',
    'bootstrap' => ['log'],
		//'catchAll' => ['main/service'],
		'defaultRoute' => 'main/index',
		'timeZone' => 'Europe/Kiev',
		'modules' => [
        'admin' => [
            'class' => 'app\modules\admin\Admin'
				]
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\modules\admin\models\Admin',
            'enableAutoLogin' => true,
						'authTimeout' => 86400
        ],
        'errorHandler' => [
            'errorAction' => 'main/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
		'urlManager' => [
						'enablePrettyUrl' => true,
						'showScriptName' => false,
						//'enableStrictParsing'=>true,
            'rules' => [
								'main/<slug:[\w-]+>' => 'main/view',
								'admin' => 'admin/default/index',
								'admin/<controller>' => 'admin/<controller>/index',
								'admin/<controller>/<action>/<id:\d+>' => 'admin/<controller>/<action>',	
								'<module>/admin' => '<module>/admin/a/index',
								'<module>/admin/<controller>/<action>/<id:\d+>'=>'<module>/admin/<controller>/<action>',
            ],
        ],
		'assetManager' => [
            // uncomment the following line if you want to auto update your assets (unix hosting only)
            //'linkAssets' => true,
			'appendTimestamp'=>true,
			//'forceCopy'=>true,
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'js' => [YII_DEBUG ? 'jquery.js' : 'jquery.min.js'],
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [YII_DEBUG ? 'css/bootstrap.css' : 'css/bootstrap.min.css'],
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js' => [YII_DEBUG ? 'js/bootstrap.js' : 'js/bootstrap.min.js'],
                ],
            ],
        ],
		'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'sourceLanguage' => 'uk-UA',
                    //'basePath' => '@app/messages',
                    'fileMap' => [
                        'app' => 'app.php',
                    ]
                ]
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
