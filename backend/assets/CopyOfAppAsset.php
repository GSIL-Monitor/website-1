<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/bootstrap-cerulean.min.css',
        'css/fullcalendar.css',
        'css/fancybox.css',
        'css/jquery-ui.css',
        'css/fullcalendar.print.css',
        'css/chosen.min.css',
        'css/colorbox.css',
        'css/responsive-tables.css',
        'css/bootstrap-tour.min.css',
        'css/jquery.noty.css',
        'css/noty_theme_default.css',
        'css/elfinder.min.css',
        'css/elfinder.theme.css',
        'css/jquery.iphone.toggle.css',
        'css/uploadify.css',
        'css/animate.min.css',
        'css/charisma-app.css',
        'scripts/jquery-ui/jquery-ui-1.10.0.custom.css',
        'css/font-awesome.min.css',
        'css/common.css',
        'css/jquery.datetimepicker.css',
        'css/emoji.css',
    ];
    
    public $js = [
        'scripts/bootstrap.min.js',
        'scripts/layer/layer.js',
        'scripts/jquery.cookie.js',
        'scripts/moment.min.js',
        'scripts/jquery.form.min.js',
        'scripts/jquery.dataTables.min.js',
        'scripts/chosen.jquery.min.js',
        'scripts/jquery.colorbox-min.js',
        'scripts/jquery.noty.js',
        'scripts/responsive-tables.js',
        'scripts/bootstrap-tour.min.js',
        'scripts/jquery.raty.min.js',
        'scripts/jquery.iphone.toggle.js',
        'scripts/jquery.autogrow-textarea.js',
        'scripts/jquery.uploadify-3.1.min.js',
        'scripts/jquery.history.js',
        'scripts/jquery-ui/jquery-ui-1.10.0.custom.min.js',
        'scripts/jquery-ui/jquery-ui.zh-CN.js',
        'scripts/charisma.js',
        'scripts/app/common.js',
        'scripts/plupload/plupload.full.min.js',
        'scripts/mindmup-editabletable.js',
        'scripts/numeric-input-example.js',
        'scripts/fullcalendar.min.js',
        'scripts/jquery.fancybox-1.3.1.pack.js',
        'scripts/jquery.datetimepicker.full.min.js',
        'scripts/qiniu.js',
        'scripts/highcharts/highcharts.js',
        'scripts/echarts.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'backend\assets\IEhack'
    ];
}
