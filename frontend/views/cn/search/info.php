<?php
/**
 * @link http://www.shuwon.com/
 * @copyright Copyright (c) 2016 成都蜀美网络技术有限公司
 * @license http://www.shuwon.com/
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use kucha\ueditor\UEditor;
use yii\helpers\ArrayHelper;
use frontend\assets\AppAsset;

?>
<?= $this->render('/layouts/header') ?>
<div class="container">
    <div class="sub_banner"><img src="<?= Yii::$app->params['face'] ?>" alt="关于我们"/></div>
    <div class="w1200">
        <div class="news_detail">
            <div class="detail_content">
                <div class="ndc_top">
                    <div class="title"><?= $newsinfo->news_title ?></div>
                    <div class="des">
                        浏览次数：<span><?= $newsinfo->news_click ?></span>发布时间：<span><?= date('Y-m-d', $newsinfo->created_at) ?></span>
                    </div>
                    <div class="social">
                        <div class="bdsharebuttonbox" data-tag="share_1">
                            <a class="weichat" data-cmd="weixin"></a>
                            <a class="weibo" data-cmd="tsina"></a>
                            <a class="qzone" data-cmd="qzone" href="#"></a>
                            <a class="qq" data-cmd="sqq"></a>
                        </div>
                    </div>
                    <div class="ndc_detail">
                        <?= $newsinfo->news_content ?>
                    </div>
                </div>

            </div>
            <div class="detail_same">
                <div class="title">更多资讯</div>
                <div class="detail_same_list">
                    <ul>
                        <?php foreach ($recommend->models as $list) { ?>
                            <li>
                                <a href="<?= Url::toRoute(['news/info', 'cate_id' => $list->news_cate, 'id' => $list->news_id]) ?>">
                                    <b><?= $list->news_title ?></b>
                                    <p><?= $list->news_abs ?></p>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="detail_same">
        <div class="case-list ss flexbox">
            <p class="title common ">精品案例 / <span>Excellent Case</span></p>
            <?php foreach (\frontend\controllers\CaseController::recommend() as $kk=>$vv){?>
                <a href="<?=Url::toRoute(['case/detail','id'=>$vv->single_id])?>">
                    <div class="img-box" style="background-image:url(<?=Yii::getAlias('@static').'/'.$vv->single_face?>)">
                        <img src="/static/assets/images/cover.png" alt="">
                    </div>
                    <div class="text">
                        <p class="name"><?=$vv->single_title?></p>
                        <p class="addr"><span class="iconfont">&#xe600;</span><?=$vv->single_subtitle?></p>
                    </div>
                </a>
            <?php }?>
        </div>
    </div>
</div>
<?= $this->render('/layouts/footer') ?>
<?php
$js = <<<JS
    window._bd_share_config = {
		common : {
			bdText : '$newsinfo->news_abs',	
			bdDesc : '$newsinfo->news_title',	
			bdUrl :  window.location.href, 
		},
		share : [{
			"bdSize" : 16
		}],
		
		image : [{
			viewType : 'list',
			viewPos : 'top',
			viewColor : 'black',
			viewSize : '16',
			viewList : ['qzone','tsina','huaban','tqq','renren']
		}],
		selectShare : [{
			"bdselectMiniList" : ['qzone','tqq','kaixin001','bdxc','tqf']
		}]
	}
    with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?cdnversion='+~(-new Date()/36e5)];
	// 浏览器特征检测插件
    Modernizr.load({
        test: Modernizr.csstransforms3d, // 需要检测的属性
        yep: ['/static/assets/lib/js/swiper.min.js', '/static/assets/lib/style/swiper.css'], // 检测通过 （支持）需要加载的文件路径
        nope: ['/static/assets/lib/js/idangerous.swiper2.7.6.min.js', '/static/assets/lib/style/idangerous.swiper2.7.6.css'], // 检测不通过通过 （不支持） 需要加载的文件路径
        //both: [], // 其他 与测试结果无关 （都会加载） 需要加载的文件路径
        complete: function (e) {
            // do something 加载完成的回调
            if (Modernizr.csstransitions) {
                var sub_banner = new Swiper('.sub_banner.swiper-container', {
					pagination: {
						el: '.sub_banner .swiper-pagination',
						clickable: true,
					},
					speed:1000,
                    autoplay: {
                        delay: 5000,
                        stopOnLastSlide: false,
                        disableOnInteraction: false,
                    },
				});
            } else {
                
            }
        }
    })
JS;
$this->registerJs($js);
?>

