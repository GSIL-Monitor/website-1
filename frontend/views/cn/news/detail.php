<?php
//                              _(\_/)
//                             ,((((^`\         //+--------------------------------------------------------------
//                            ((((  (6 \        //|Copyright (c) 2017 http://www.shuwon.com All rights reserved.
//                          ,((((( ,    \       //+--------------------------------------------------------------
//      ,,,_              ,(((((  /"._  ,`,     //|Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
//     ((((\\ ,...       ,((((   /    `-.-'     //+--------------------------------------------------------------
//     )))  ;'    `"'"'""((((   (               //|Author: xww < xww@wyw1.cn >
//    (((  /            (((      \              //+--------------------------------------------------------------
//     )) |                      |
//    ((  |        .       '     |
//    ))  \     _ '      `t   ,.')
//    (   |   y;- -,-""'"-.\   \/
//    )   / ./  ) /         `\  \
//       |./   ( (           / /'                __     __
//       ||     \\          //'|                /  \~~~/  \
//       ||      \\       _//'||          ,----(     ..    )
//       ||       ))     |_/  ||         /      \__     __/
//       \_\     |_/          ||       /|         (\  |(
//       `'"                  \_\     ^ \   /___\  /\ |
//                            `'"        |__|   |__|-"
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use kucha\ueditor\UEditor;
use yii\helpers\ArrayHelper;
use frontend\assets\AppAsset;

?>

<div class="container common-padding clearfix">
    <div class="path">
        <img src="/static/assets/images/path.png" alt="">
        <p>您的位置： <a href="/">首页</a> > <a href="">新闻资讯</a> > 高层动态</p>
    </div>
    <div class="menu">
        <?= $this->render('/'.Yii::$app->params['lang_str'].'/layouts/subNav') ?>
    </div>
    <div class="content news bg">
        <div class="path-name">新闻详情</div>
        <div class="news_d">
            <div class="news_detail">
                <div class="detail_content">
                    <div class="ndc_top">
                        <div class="title"><?=$info->news_title?></div>
                        <div class="des">发布者：<span><?=$info->news_author?></span>浏览次数：<span><?=$info->news_click?></span>发布时间：<span><?=$info->time??date('Y-m-d',$info->created_at)?></span></div>
                        <div class="social">
                            <div class="bdsharebuttonbox" data-tag="share_1">
                                <a class="weichat" data-cmd="weixin"></a>
                                <a class="weibo" data-cmd="tsina"></a>
                                <a class="qzone" data-cmd="qzone" href="#"></a>
                                <a class="qq" data-cmd="sqq"></a>
                            </div>
                        </div>
                        <div class="ndc_detail">
                            <?=$info->news_content?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<?php
//AppAsset::addScript($this, '');
$js=<<<JS
	 window.onload = function () {
        echo.init({
            callback: function (element, op) {
                if (op === 'load') {
                    element.classList.add('loaded');
                } else {
                    element.classList.remove('loaded');
                }
            }
        });
    }
    window._bd_share_config = {
		common : {
			bdText : '自定义分享内容',	
			bdDesc : '自定义分享摘要',	
			bdUrl : '自定义分享url地址', 	
			bdPic : '自定义分享图片'
		},
		share : [{
			"bdSize" : 16
		}],
		selectShare : [{
			"bdselectMiniList" : ['qzone','tqq','kaixin001','bdxc','tqf']
		}]
	}
	with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?cdnversion='+~(-new Date()/36e5)];
JS;
$this->registerJs($js);
?>

