<?php
return [
    'errorReport' => true,  //是否开启错误报告
    'errorEmail' => '813465033@qq.com',//开发者邮箱或项目经理邮箱
    'adminEmail' => '18144397677@163.com',
    'supportEmail' => '18144397677@163.com',
    'user.passwordResetTokenExpire' => 3600,
    'AppName' => '后台管理系统',//应用名称
    'SuperAdmin' => 'shuwon',//超级管理员账号
    'version'=>'Beta 2.1',
    'shuwon'=>'http://www.shuwon.com',
    'wechat' => [
        'token' => '',
        'redirect_uri' => '',
        'appid' => '',
        'appsecret' => '',
        'mchid' => '',
        'key' => '',
        'notifyUrl' => '',
    ],//微信公众号开发
    'webuploader_driver' => 'local',//local or qiniu
    'qiniu' => [
        'domain' => 'http://',
        'bucket' => '',
        'accessKey' => '',
        'secretKey' => '',
        'server'=>'http://up-z2.qiniu.com/',
    ],//七牛云配置
	'enabled' => [
	1=>'启用',
	2=>'禁用',
	],//是否显示
	'top' => [
	1=>'首页',
	2=>'不首页',
    ],//是否推荐到首页
    'lang' => [
		1=>'cn',
		2=>'en'
    ],
    'lang_version' => [
		'cn' => '简体中文',
		'en' => 'English'
	],
	'recommend' => [
	1=>'推荐',
	2=>'不推荐',
	],//是否推荐到首页
    'sex' => [
        1=>'男',
        2=>'女',
    ],
    'checkType' => [
        1=>'多选',
        2=>'单选',
    ],
];
