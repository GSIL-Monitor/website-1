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
<div class="video-box">
    <div class="video_">
        <video src="/static/assets/video/video.mp4" id="video" controls preload></video>
        <div class="close"></div>
    </div>
</div>
<div class="container index-page">
    <script src="//api.html5media.info/1.2.2/html5media.min.js"></script>
    <div class="w1200">
        <div class="banner">

               
                    <div class="title">
                            <h4><a href="<?= $v->img_content ?? '#' ?>"><?=$banner[0]->img_title?></a></h4>
                            <p><?=$banner[0]->img_filed?></p>
                    </div>
                



            <div class="slick">
                <?php foreach ($banner as $k => $v) { ?>
                    <div class="item" data-title="<?= $v->img_title ?>" data-abs="<?= $v->img_filed ?>">
                        <div class="img-box"
                             style="background-image:url(<?= Yii::getAlias('@static') . '/' . $v->img_face ?>)">
                            <a href="<?= $v->img_content ?? '#' ?>"><img src="/static/assets/images/indexCover.png"
                                                                         alt=""></a>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="box1 clearfix">
                <div class="tips clearfix">
                    <div class="lb">
                        <img src="/static/assets/images/lb.png" alt="">
                    </div>
                    <div class="wrap">
                        <ul>
                            <?php foreach ($banner as $k => $v) { ?>
                                <a href="<?= $v->img_content ?? '#' ?>">
                                    <li class="clearfix"><p><?= $v->img_title ?></p>
                                        <p class="time"><?= date('Y-m-d', $v->created_at) ?></p>
                                    </li>
                                </a>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                <div class="ctrl">
                    <img src="/static/assets/images/arrl.png" alt="" class="left">
                    <img src="/static/assets/images/arrr.png" alt="" class="right">
                </div>
            </div>
        </div>
        <div class="box2 clearfix">
            <div class="box-left">
                <div class="tab common clearfix">
                    <?php foreach (\common\models\Category::getParent('news', 1) as $kk => $vv) { ?>
                        <div class="item <?= $kk == 0 ? 'active' : '' ?>">
                            <a href="news/<?= $vv->cate_id ?>.html"><?= $vv->cate_title ?></a>
                        </div>
                    <?php } ?>
                    <div class="more">
                        <a href="news.html">更多>></a>
                    </div>
                </div>
                <div class="lists">
                    <?php foreach (\common\models\Category::getParent('news', 1) as $k => $v) { ?>
                        <?php $news_s = \frontend\controllers\HomeController::getNews($v->cate_id);?>
                            <div class="list <?= $k == 0 ? 'active' : '' ?>">
                                <?php foreach ($news_s as $kk => $vv) { ?>
                                    <a href="<?= Url::toRoute(['news/detail', 'id' => $vv->news_id]) ?>"
                                       class="clearfix ">
                                        <p><?= $vv->news_title ?></p>
                                        <p class="time"><?= date('Y-m-d', $vv->created_at) ?></p>
                                    </a>
                                <?php } ?>
                            </div>
                    <?php } ?>
                </div>
            </div>
            <div class="box-right">
                <div class="tab1 common clearfix">
                    <div class="item1">
                        业务频道
                    </div>
                    <div class="more">
                        <a href="<?= Url::toRoute(['business/index']) ?>">更多>></a>
                    </div>
                </div>
                <div class="list_ clearfix">
                    <a href="<?= Url::toRoute(['business/accuracy']) ?>" class="clearfix">
                        <div class="img-box">
                            <img src="/static/assets/images/icon1.png" alt="">
                        </div>
                        <h4>几何量、计量器具<span>检定校准</span></h4>
                    </a>
                    <a href="<?= Url::toRoute(['business/measure']) ?>" class="clearfix">
                        <div class="img-box">
                            <img src="/static/assets/images/icon2.png" alt="">
                        </div>
                        <h4>大型机械零部件<span>几何量精密检测</span></h4>
                    </a>
                    <a href="<?= Url::toRoute(['business/testing']) ?>" class="clearfix">
                        <div class="img-box">
                            <img src="/static/assets/images/icon3.png" alt="">
                        </div>
                        <h4>大型数控机床<span>精度检测</span></h4>
                    </a>
                    <a href="<?= Url::toRoute(['business/geometry']) ?>" class="clearfix">
                        <div class="img-box">
                            <img src="/static/assets/images/icon4.png" alt="">
                        </div>
                        <h4>各种工程项目<span>几何量参数检测</span></h4>
                    </a>
                </div>
            </div>
        </div>
        <div class="box3 clearfix">
            <a href="">
                <img src="/static/assets/images/index1.jpg" alt="">
            </a>
            <a href="">
                <img src="/static/assets/images/index2.jpg" alt="">
            </a>
        </div>
    </div>
    <div class="box2">
        <div class="w1200 clearfix">
            <div class="box-left">
                <div class="tab common clearfix">
                    <?php foreach (\common\models\Category::getSon('14') as $k => $v) { ?>
                        <div class="item <?= $k == 0 ? 'active' : '' ?>">
                            <a href="news/<?= $v->parent_id ?>/<?= $v->cate_id ?>.html"><?= $v->cate_title ?></a>
                        </div>
                    <?php } ?>
                    <div class="more">
                        <a href="/news/14/21.html">更多>></a>
                    </div>
                </div>
                <div class="lists">
                    <?php foreach (\common\models\Category::getSon(14) as $k => $v) { ?>
                        <?php $news_s = \frontend\controllers\HomeController::getFz($v->cate_id);?>
                            <div class="list <?= $k == 0 ? 'active' : '' ?>">
                                <?php foreach ($news_s as $kk => $vv) { ?>
                                    <a href="<?= Url::toRoute(['news/detail', 'id' => $vv->news_id]) ?>"
                                       class="clearfix ">
                                        <p><?= $vv->news_title ?></p>
                                        <p class="time"><?= date('Y-m-d', $vv->created_at) ?></p>
                                    </a>
                                <?php } ?>
                            </div>
                    <?php } ?>
                </div>
            </div>
            <div class="box-right clearfix">
                <div class="tab1 common clearfix">
                    <div class="item1">
                        视频介绍
                    </div>
                </div>
                <div class="img-box" style="cursor: pointer;">
                    <img src="/static/assets/images/videocover.png" alt="">
                </div>
            </div>
        </div>
    </div>
    <div class="w1200">
        <div class="box5 clearfix">
            <div class="box-left">
                <div class="tab1 common clearfix">
                    <div class="item1">
                        通知公告
                    </div>
                    <div class="more">
                        <a href="/news/18.html">更多>></a>
                    </div>
                </div>
                <div class="list">
                    <?php foreach (\frontend\controllers\HomeController::getNews('18', 6) as $k => $v) { ?>
                        <a href="<?= Url::toRoute(['news/detail', 'id' => $v->news_id]) ?>" class="clearfix">
                            <div class="time">
                                <p class="day"><?= date('d', $v->created_at) ?></p>
                                <p><?= date('Y-m', $v->created_at) ?></p>
                            </div>
                            <div class="info">
                                <p class="title"><?= $v->news_title ?></p>
                                <div class="des">
                                    <p><?= $v->news_abs ?></p>
                                </div>
                            </div>
                        </a>
                    <?php } ?>

                </div>
            </div>
            <div class="box-right">
                <div class="tab1 common clearfix">
                    <div class="item1">
                        单位简介
                    </div>
                    <div class="more">
                        <a href="/about.html">更多>></a>
                    </div>
                </div>
                <div class="text-box">
                     <div class="info io">
                        <!-- <?=$rcdw->single_content?> -->
                        <p>国家重大技术装备几何量计量站，是2006年经国家质检总局授权建立的国内唯一一个从事重大技术装备几何量检测的专业计量站；四川重大技术装备几何量计量站，是2007年经四川省编委批复成立的省级法定计量技术机构，系“两块牌子，一套班子”。目前拥有中心实验室、第一实验室（中国二重）、第二实验室（东方电机）、第三实验室（东方汽轮机）、成都大尺寸精密检测实验室、中英联合实验室、四川（国家）重装站泸州计量检测中心等9个专业实验室，实验室面积5200㎡，配有2.2亿元国际领先水平的检测设备。</p>
                        <p>我站拥有一支高水平、高素质的专业技术人才队伍。其中，正高级工程师3人、副高级工程师12人、工程师26人、高级技师和技师23名，技术人员占比80%。<a href="/about.html">[查看更多]</a></p>
                     </div>
                     
                </div>
            </div>
        </div>
        <div class="box6">
            <div class="tab common clearfix">
                <div class="item active">
                    <a href="<?= Url::toRoute(['strength/index', 'id' => 'center']) ?>">中心实验室</a>
                </div>
                <div class="item">
                    <a href="<?= Url::toRoute(['strength/index', 'id' => '1st']) ?>">第一实验室</a>
                </div>
                <div class="item">
                    <a href="<?= Url::toRoute(['strength/index', 'id' => '2nd']) ?>">第二实验室</a>
                </div>
                <div class="item">
                    <a href="<?= Url::toRoute(['strength/index', 'id' => '3rd']) ?>">第三实验室</a>
                </div>
                <div class="more">
                    <a href="<?= Url::toRoute(['strength/index', 'id' => 'center']) ?>">更多>></a>
                </div>
            </div>
            <div class="lists">
                <div class="list clearfix active">
                    <?php foreach (\frontend\controllers\HomeController::getImg('center-laboratory', 4) as $kk => $vv) { ?>
                        <div class="item">
                            <div class="img-box"
                                 style="background-image:url(<?= Yii::getAlias('@static') . '/' . $vv->img_face ?>)">
                                <img src="/static/assets/images/labcover.png" alt="">
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="list clearfix">
                    <?php foreach (\frontend\controllers\HomeController::getImg('1st-laboratory', 4) as $kk => $vv) { ?>
                        <div class="item">
                            <div class="img-box"
                                 style="background-image:url(<?= Yii::getAlias('@static') . '/' . $vv->img_face ?>)">
                                <img src="/static/assets/images/labcover.png" alt="">
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="list clearfix">
                    <?php foreach (\frontend\controllers\HomeController::getImg('2nd-laboratory', 4) as $kk => $vv) { ?>
                        <div class="item">
                            <div class="img-box"
                                 style="background-image:url(<?= Yii::getAlias('@static') . '/' . $vv->img_face ?>)">
                                <img src="/static/assets/images/labcover.png" alt="">
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="list clearfix">
                    <?php foreach (\frontend\controllers\HomeController::getImg('3rd-laboratory', 4) as $kk => $vv) { ?>
                        <div class="item">
                            <div class="img-box"
                                 style="background-image:url(<?= Yii::getAlias('@static') . '/' . $vv->img_face ?>)">
                                <img src="/static/assets/images/labcover.png" alt="">
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
AppAsset::addScript($this, 'http://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js');
AppAsset::addCss($this, 'http://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css');
$js = <<<JS
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
        var items = $('.slick .item')
        $('.slick').slick({
			dots: true,
			infinite: true,
			speed: 500,
            arrows:false,
			slidesToShow: 1,
            autoplaySpeed:4000,
			slidesToScroll: 1
		})

        $('.slick').on('beforeChange', function(event, slick, currentSlide, nextSlide){
            $('.index-page .banner .title h4').text(items.eq(nextSlide).attr('data-title'))
            $('.index-page .banner .title p').text(items.eq(nextSlide).attr('data-abs'))
        });

        $('.index-page .box1 .ctrl .left').click(function(){
            $('.slick').slick('slickPrev')
        })

        $('.index-page .box1 .ctrl .right').click(function(){
            $('.slick').slick('slickNext')
        })

        scroll()
    }

    $('.tab.common .item').hover(function(){
        $(this).addClass('active').siblings().removeClass('active')
        $(this).parent().next().find('.list').eq($(this).index()).addClass('active').siblings().removeClass('active')
    })

    $('.index-page .box2 .box-right img').click(function(){
        var video = document.getElementById('video')
        $('.video-box').show()
        video.play()
    })

    $('.video-box .close').click(function(){
        $('.video-box').hide()
        video.pause()
    })

    function scroll(){
        var ul = $('.index-page .box1 .wrap ul').height(),
            l = $('.index-page .box1 .wrap ul li').length,
            li = $('.index-page .box1 .wrap li').height(),
            active = 0;
        setInterval(function(){
            next_()
        },3000)

        function next_(){
            if(l == active + 1){
                
                $('.index-page .box1 .wrap ul').animate({top:(li * active + 1) * -1 },250,function(){
                    $('.index-page .box1 .wrap ul').css('top', li + 'px')
                    $('.index-page .box1 .wrap ul').animate({top:0},250)
                    active = 0
                })
            }else{
                active += 1
                $('.index-page .box1 .wrap ul').animate({top:(li * active) * -1},500)
            }
        }
    }
JS;
$this->registerJs($js);
?>

