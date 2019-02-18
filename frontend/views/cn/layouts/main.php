<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
	<meta name="author" content="http://www.shuwon.com" />

    <meta name="keywords" content="<?=!empty(Yii::$app->params['title'])?Yii::$app->params['title']:Yii::$app->params['web_site_config']['keywords']?>" />
    <meta name="description" content="<?=!empty(Yii::$app->params['description'])?Yii::$app->params['description']:Yii::$app->params['web_site_config']['web_site_description']?>" />

    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <!-- Set render engine for 360 browser -->
    <meta name="renderer" content="webkit">
    <!-- No Baidu Siteapp-->
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <!-- Add to homescreen for Chrome on Android -->
    <meta name="mobile-web-app-capable" content="yes">
    <!-- Add to homescreen for Safari on iOS -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <?= Html::csrfMetaTags() ?>
    <title><?=!empty(Yii::$app->params['title'])?Yii::$app->params['title']:Yii::$app->params['web_site_config']['web_site_title']?></title>

    <?php $this->head() ?>

</head>

<body class="main">

<?php $this->beginBody() ?>
<div class="header">
<?=$this->render('/'.Yii::$app->params['lang_str'].'/layouts/header')?>
</div>
<?=$content?>
<div class="footer">
<?=$this->render('/'.Yii::$app->params['lang_str'].'/layouts/footer')?>
</div>
<?php $this->endBody() ?>

</body>

</html>
<?php $this->endPage() ?>
