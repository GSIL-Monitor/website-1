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
        <div class="path-name"><?=\common\models\Category::getCateName($p_cate)?></div>
        <div class="lists">
            <?php foreach ($list->models as $k=>$v){?>
            <a href="<?=Url::toRoute(['news/detail','id'=>$v->news_id])?>" class="clearfix">
                <p class="title"><?=mb_strlen($v->news_title,'utf-8')>40?mb_substr($v->news_title,0,40,'utf-8').'...':$v->news_title?></p>
                <p class="time"><?=date('Y-m-d',$v->created_at)?></p>
            </a>
            <?php }?>
        </div>
        <div class="pages" data-count="<?=$count?>">

        </div>
    </div>
</div>
<?php
AppAsset::addScript($this, '');
$js=<<<JS
	 
JS;
$this->registerJs($js);
?>

