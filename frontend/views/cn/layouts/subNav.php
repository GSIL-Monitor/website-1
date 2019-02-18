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

?>
<?php if ($controller == 'about') { ?>
    <p class="title">
        <img src="/static/assets/images/menu.png" alt="">
        关于我们
    </p>
    <div class="lists">
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
<?php } elseif ($controller == 'strength') { ?>
    <p class="title">
        <img src="/static/assets/images/menu.png">
        检测实力
    </p>
    <div class="lists">
        <a href="<?= Url::toRoute(['strength/index', 'id' => 'center']) ?>"
           class="<?= $this->params['isActive'] == 'center' ? 'active' : '' ?>">中心实验室</a>
        <a href="<?= Url::toRoute(['strength/index', 'id' => '1st']) ?>"
           class="<?= $this->params['isActive'] == '1st' ? 'active' : '' ?>">第一实验室</a>
        <a href="<?= Url::toRoute(['strength/index', 'id' => '2nd']) ?>"
           class="<?= $this->params['isActive'] == '2nd' ? 'active' : '' ?>">第二实验室</a>
        <a href="<?= Url::toRoute(['strength/index', 'id' => '3rd']) ?>"
           class="<?= $this->params['isActive'] == '3rd' ? 'active' : '' ?>">第三实验室</a>
        <div class="more">
            <p>人才实力</p>
            <div class="list">
                <a href="<?= Url::toRoute(['strength/personnel-strength']) ?>"
                   class="<?= $this->params['isActive'] == 'personnel-strength' ? 'active' : '' ?>">人才实力</a>
                <a href="<?= Url::toRoute(['strength/team-building']) ?>"
                   class="<?= $this->params['isActive'] == 'team-building' ? 'active' : '' ?>">人才队伍建设</a>
                <div class="more">
                    <p>文化建设</p>
                    <div class="list">
                        <a href="<?= Url::toRoute(['strength/star']) ?>"
                           class="<?= $this->params['isActive'] == 'star' ? 'active' : '' ?>">服务明星</a>
                        <a href="<?= Url::toRoute(['strength/employees']) ?>"
                           class="<?= $this->params['isActive'] == 'employees' ? 'active' : '' ?>">职工之间</a>
                    </div>
                </div>
                <a href="<?= Url::toRoute(['strength/join-us']) ?>"
                   class="<?= $this->params['isActive'] == 'join-us' ? 'active' : '' ?>">招贤纳才</a>
                <a href="<?= Url::toRoute(['strength/technological-innovation']) ?>"
                   class="<?= $this->params['isActive'] == 'technological-innovation' ? 'active' : '' ?>">科技创新</a>
            </div>
        </div>
    </div>
<?php } elseif ($controller == 'business') { ?>
    <p class="title">
        <img src="/static/assets/images/menu.png" alt="">
        业务频道
    </p>
    <div class="lists">
        <a href="<?= Url::toRoute(['business/index']) ?>"
           class="<?= $this->params['isActive'] == 'business' ? 'active' : '' ?>">业务频道</a>
        <a href="<?= Url::toRoute(['business/case']) ?>"
           class="<?= $this->params['isActive'] == 'case' ? 'active' : '' ?>">成功案例</a>
    </div>
<?php } elseif ($controller == 'communication') { ?>
    <p class="title">
        <img src="/static/assets/images/menu.png" alt="">
        交流互动
    </p>
    <div class="lists">
        <a href="<?=Url::toRoute(['communication/smailindex'])?>" class="<?= $this->params['isActive'] == 'jzxx' ? 'active' : '' ?>">局长信箱</a>
        <a href="<?=Url::toRoute(['communication/opinion'])?>" class="<?= $this->params['isActive'] == 'yjzj' ? 'active' : '' ?>">意见征集</a>
        <a href="<?=Url::toRoute(['communication/survey'])?>" class="<?= $this->params['isActive'] == 'wsdc' ? 'active' : '' ?>">网上调查</a>
        <a href="<?=Url::toRoute(['communication/online'])?>" class="<?= $this->params['isActive'] == 'zxft' ? 'active' : '' ?>">在线访谈</a>
    </div>
<?php } elseif ($controller == 'service') { ?>
    <p class="title">
        <img src="/static/assets/images/menu.png" alt="">
        客服中心
    </p>
    <div class="lists">
        <a href="<?=Url::toRoute(['service/charges'])?>" class="<?= $this->params['isActive'] == 'charges' ? 'active' : '' ?>">收费标准</a>
        <a href="<?=Url::toRoute(['service/process'])?>" class="<?= $this->params['isActive'] == 'process' ? 'active' : '' ?>">送检过程</a>
        <a href="<?=Url::toRoute(['service/guide'])?>" class="<?= $this->params['isActive'] == 'guide' ? 'active' : '' ?>">办事指南</a>
    </div>
<?php } elseif ($controller == 'news') { ?>
    <p class="title">
        <img src="/static/assets/images/menu.png" alt="">
        新闻资讯
    </p>
    <div class="lists">
        <?php foreach (\common\models\Category::getParent('news') as $k => $v) { ?>
            <?php $cate_son = \common\models\Category::getSon($v->cate_id) ?>
            <?php if (empty($cate_son)) { ?>
                <a href="/news/<?=$v->cate_id?>.html" class="<?=$this->params['p_cate']==$v->cate_id?'active':''?>"><?= $v->cate_title ?></a>
            <?php } else { ?>
                <div class="more <?=$this->params['p_cate']==$v->cate_id?'active':''?>">
                    <p><?= $v->cate_title ?></p>
                    <div class="list">
                        <?php foreach ($cate_son as $kk => $vv) { ?>
                            <a href="/news/<?=$v->cate_id?>/<?=$vv->cate_id?>.html" class="<?=$this->params['cate']==$vv->cate_id?'active':''?>"><?=$vv->cate_title?></a>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
<?php } elseif ($controller == 'special') { ?>
    <p class="title">
        <img src="/static/assets/images/menu.png" alt="">
        专题专栏
    </p>
    <div class="lists">
        <?php foreach (\common\models\Category::getParent('special') as $k => $v) { ?>
            <?php $cate_son = \common\models\Category::getSon($v->cate_id) ?>
            <?php if (empty($cate_son)) { ?>
                <a href="/special/<?=$v->cate_id?>.html" class="<?=$this->params['p_cate']==$v->cate_id?'active':''?>"><?= $v->cate_title ?></a>
            <?php } else { ?>
                <div class="more <?=$this->params['p_cate']==$v->cate_id?'active':''?>">
                    <p><?= $v->cate_title ?></p>
                    <div class="list">
                        <?php foreach ($cate_son as $kk => $vv) { ?>
                            <a href="/special/<?=$v->cate_id?>/<?=$vv->cate_id?>.html" class="<?=$this->params['cate']==$vv->cate_id?'active':''?>"><?=$vv->cate_title?></a>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
<?php } else { ?>


<?php } ?>