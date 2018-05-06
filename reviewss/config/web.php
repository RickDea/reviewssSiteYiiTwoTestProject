<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
		
			'baseUrl'=> '',
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'mfn3ey3uy5FNDEF3uiNFEDKFnji3t',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
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
        'db' => $db,
        
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
			'review/<id:\w+>'=>'/site/postpage',
			'enter'=>'site/enter',
			'registr'=>'site/registr',
			'user/<name:\w+>/<page:\w+>'=>'site/user',
			'user/<name:\w+>'=>'site/user',
			'profile/<t:\w+>/<page:\w+>'=>'site/profile',
			'profile/<t:\w+>'=>'site/profile',
			'messages/<t:\w+>/<page:\w+>'=>'site/messages',
			'messages/<t:\w+>'=>'site/messages',
			'message/<id:\w+>'=>'site/message',
			'edit/<id:\w+>'=>'site/editpost',
			'add'=>'site/addpost',
			'send/<n:\w+>'=>'site/send',
			'send'=>'site/send',
			'password'=>'site/changepassword',
			
			'/<page:\w+>'=>'site/index',
			''=>'site/index',
			
			
            ],
        ],
        
    ],
    'params' => $params,
];

/*if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}*/

return $config;
