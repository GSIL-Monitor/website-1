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
    <div class="_w1200">
            <div class="searchContent">
                <div class="scResult">搜索结果页</div>
                <div class="resultTips">找到关于“<span><?= $keywords ?></span>”的结果数约<span><?= $count ?></span>条</div>
            </div>
    
            <!-- 如果没有数据，则给noData加一个active -->
            <div class="noData <?= $count == 0 ? 'active' : '' ?>">没有搜索到相关数据</div>
    
            <div class="focus2_list">
                <ul>
                    <?php foreach ($provider->models as $list) { ?>
                        <li style="width:100%;">
                            <div class="title"><a
                                        href="<?= Url::toRoute(['news/detail', 'id' => $list->news_id]) ?>"><?= $list->news_title ?></a>
                            </div>
                            <div class="time"><?= date('Y-m-d', $list->created_at) ?></div>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <div class="pages" data-count="<?=$count?>" data-keywords="<?=$keywords?>">
    
            </div>
        </div>
</div>
<?php
AppAsset::addScript($this, '');
$js=<<<JS
	 
JS;
$this->registerJs($js);
?>

