<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
            'cachePath' => '@runtime/cache2',
        ],
        'redis' => [
	        'class' => 'yii\redis\Connection',
	        'hostname' => '127.0.0.1',
	        'port' => 6379,
	        'database' => 0,
        ],
    	
    ],
];
