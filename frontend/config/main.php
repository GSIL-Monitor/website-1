<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'timeZone' => 'PRC',
    'language' => 'zh-CN',
    'controllerNamespace' => 'frontend\controllers',
    'components' => [

        'session'=>[
            'timeout'=>3600*24*30,
            'cookieParams' => [
                'httpOnly' => false,
                'path' => '/',
            ],
        ],
        'user' => [
            'identityClass' => 'backend\models\User',
            'enableAutoLogin' => true,
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'request' => [
	        // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
	        'cookieValidationKey' => '35xxxsMx_h6VqgeMM9zeaaaTnss0EDsC',
	        'enableCookieValidation' => false,
	        'enableCsrfValidation' => false,
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => true,
            'suffix' => '.html',
            'rules' => [

               '/'					    => 'home/index',
			   'ie'						=> '/site/ie',
			   'start'					=> 'site/start',

                '/<lang:\w+>'			            => 'home/index',
            ],
        ],
        'assetManager' => [
		 'bundles' => [
		     'yii\web\YiiAsset' => [
		         'js' => [],  // 去除 yii.js
		         'sourcePath' => null,  // 防止在 frontend/web/asset 下生产文件
		     ],
		                        
		     'yii\widgets\ActiveFormAsset' => [
		         'js' => [],  // 去除 yii.activeForm.js
		         'sourcePath' => null,  // 防止在 frontend/web/asset 下生产文件
		     ],
		        
		     'yii\validators\ValidationAsset' => [
		         'js' => [],  // 去除 yii.validation.js
		         'sourcePath' => null,  // 防止在 frontend/web/asset 下生产文件
		     ],
		     'yii\web\JqueryAsset' => [
	            'js' => [],  // 去除 jquery.js
	            'sourcePath' => null,  // 防止在 frontend/web/asset 下生产文件
	        ],
	        'yii\bootstrap\BootstrapAsset' => [
		         'css' => [],  // 去除 bootstrap.css
		         'sourcePath' => null, // 防止在 frontend/web/asset 下生产文件
		     ],
		     'yii\bootstrap\BootstrapPluginAsset' => [
		         'js' => [],  // 去除 bootstrap.js
		         'sourcePath' => null,  // 防止在 frontend/web/asset 下生产文件
		     ],
		 ],
		],
        
    ],
    'params' => $params,
];
