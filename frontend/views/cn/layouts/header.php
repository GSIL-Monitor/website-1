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


$controller = Yii::$app->controller->id;
$action = Yii::$app->controller->action->id;
$this->params['isActive'] = $this->params['isActive'] ?? false;
?>
<div class="top common-padding">
   <!-- <a href="">
        <span></span>无障碍版
    </a>-->
    <a href="">
        <span></span>网站地图
    </a>
    <a href="<?=Url::toRoute(['service/charges'])?>">
        <span></span>客服中心
    </a>
</div>

<div class="middle common-padding clearfix">
    <a href="/" class="logo">
        <img src="/static/assets/images/logo.png" alt="">
    </a>
    <div class="search">
        <form action="<?=Url::toRoute(['search/index'])?>">
            <input type="text" name="keywords" placeholder="请输入关键词">
            <button type="submit">搜&nbsp;索</button>
        </form>
    </div>
</div>

<div class="nav common-padding clearfix">
    <div class="item <?= $controller == 'home' ? 'active' : '' ?>">
        <a href="/"><img src="/static/assets/images/nav-icon-1.png" alt=""> 首页</a>
    </div>
    <div class="item <?= $controller == 'about' ? 'active' : '' ?>">
        <a href="<?= Url::toRoute(['about/index']) ?>"><img src="/static/assets/images/nav-icon-2.png" alt=""> 关于我们</a>
        <div class="secondary">
            <div class="list">
                <a href="<?= Url::toRoute(['about/index']) ?>"
                   class="<?= $this->params['isActive'] == 'framework' ? 'active' : '' ?>">单位简介</a>
                <a href="<?= Url::toRoute(['about/duties']) ?>"
                   class="<?= $this->params['isActive'] == 'duties' ? 'active' : '' ?>">单位职能</a>
                <a href="<?= Url::toRoute(['about/leaders']) ?>"
                   class="<?= $this->params['isActive'] == 'leaders' ? 'active' : '' ?>">领导班子</a>
                <a href="<?= Url::toRoute(['about/framework']) ?>"
                   class="<?= $this->params['isActive'] == 'framework' ? 'active' : '' ?>">组织机构</a>
                <a href="<?= Url::toRoute(['about/post']) ?>"
                   class="<?= $this->params['isActive'] == 'post' ? 'active' : '' ?>">岗位设置</a>
                <a href="<?= Url::toRoute(['about/certificate']) ?>"
                   class="<?= $this->params['isActive'] == 'certificate' ? 'active' : '' ?>">资质证书</a>
                <a href="<?= Url::toRoute(['about/memorabilia']) ?>"
                   class="<?= $this->params['isActive'] == 'memorabilia' ? 'active' : '' ?>">大事记</a>
                <a href="<?= Url::toRoute(['about/statistical']) ?>"
                   class="<?= $this->params['isActive'] == 'statistical' ? 'active' : '' ?>">统计信息</a>
            </div>
        </div>
    </div>
    <div class="item <?= $controller == 'strength' ? 'active' : '' ?>">
        <a href="<?= Url::toRoute(['strength/index', 'id' => 'center']) ?>"><img
                    src="/static/assets/images/nav-icon-4.png" alt=""> 检测实力</a>
        <div class="secondary">
            <div class="list">
                <a href="<?= Url::toRoute(['strength/index', 'id' => 'center']) ?>"
                   class="<?= $this->params['isActive'] == 'center' ? 'active' : '' ?>">中心实验室</a>
                <a href="<?= Url::toRoute(['strength/index', 'id' => '1st']) ?>"
                   class="<?= $this->params['isActive'] == '1st' ? 'active' : '' ?>">第一实验室</a>
                <a href="<?= Url::toRoute(['strength/index', 'id' => '2nd']) ?>"
                   class="<?= $this->params['isActive'] == '2nd' ? 'active' : '' ?>">第二实验室</a>
                <a href="<?= Url::toRoute(['strength/index', 'id' => '3rd']) ?>"
                   class="<?= $this->params['isActive'] == '3rd' ? 'active' : '' ?>">第三实验室</a>
                <a href="personnel-strength.html">人才实力</a>
            </div>
        </div>
    </div>
    <div class="item <?= $controller == 'business' ? 'active' : '' ?>">
        <a href="<?= Url::toRoute(['business/index']) ?>"><img src="/static/assets/images/nav-icon-3.png" alt="">
            业务频道</a>
        <div class="secondary">
            <div class="list">
                <a href="<?= Url::toRoute(['business/index']) ?>"
                   class="<?= $this->params['isActive'] == 'business' ? 'active' : '' ?>">业务频道</a>
                <a href="<?= Url::toRoute(['business/case']) ?>"
                   class="<?= $this->params['isActive'] == 'case' ? 'active' : '' ?>">成功案例</a>
            </div>
        </div>
    </div>
    <div class="item <?= $controller == 'news' ? 'active' : '' ?>">
        <a href="<?= Url::toRoute(['news/index']) ?>"><img src="/static/assets/images/nav-icon-7.png" alt=""> 新闻资讯</a>
        <div class="secondary">
            <div class="list">
                <?php foreach (\common\models\Category::getParent('news') as $k => $v) { ?>
                    <a href="/news/<?= $v->cate_id ?>.html"><?= $v->cate_title ?></a>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="item <?= $controller == 'communication' ? 'active' : '' ?>">
        <a href="<?=Url::toRoute(['communication/smailindex'])?>"><img src="/static/assets/images/nav-icon-6.png" alt=""> 互动交流</a>
        <div class="secondary">
            <div class="list">
                <a href="<?=Url::toRoute(['communication/smailindex'])?>">局长信箱</a>
                <a href="<?=Url::toRoute(['communication/opinion'])?>">意见征集</a>
                <a href="<?=Url::toRoute(['communication/survey'])?>">网上调查</a>
                <a href="<?=Url::toRoute(['communication/online'])?>">在线访谈</a>
            </div>
        </div>
    </div>
    <div class="item">
        <a href="<?=Url::toRoute(['special/index'])?>"><img src="/static/assets/images/nav-icon-8.png" alt=""> 专题专栏</a>

    </div>
    <!-- <div class="item">
        <a href="<?=Url::toRoute(['service/charges'])?>"><img src="/static/assets/images/nav-icon-8.png" alt=""> 客服中心</a>
        <div class="secondary">
            <div class="list">
                <a href="<?=Url::toRoute(['service/charges'])?>">收费标准</a>
                <a href="<?=Url::toRoute(['service/process'])?>">送检过程</a>
                <a href="<?=Url::toRoute(['service/guide'])?>">办事指南</a>
            </div>
        </div>
    </div> -->
    <div class="item <?= $controller == 'contact' ? 'active' : '' ?>">
        <a href="<?=Url::toRoute(['contact/index'])?>"><img src="/static/assets/images/nav-icon-5.png" alt=""> 联系我们</a>
    </div>
</div>