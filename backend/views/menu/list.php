<?php
/**
 * @link http://www.shuwon.com/
 * @copyright Copyright (c) 2016 成都蜀美网络技术有限公司
 * @license http://www.shuwon.com/
 */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\Json;
use yii\bootstrap\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\widgets\LinkPager;
use yii\helpers\ArrayHelper;
?>

<link href="/admin/css/animate.min.css" rel="stylesheet">
<link href="/admin/css/style.min.css" rel="stylesheet">
<style>
    .dd-item{
        line-height: 30px;
    }
    .wrapper{
        padding: 0;
    }
    .skin-blue .wrapper{
        background-color: #ffffff;
    }
    .category-box{
        padding: 10px 30px;
    }
    .operating a{
        margin-left: 8px;
        /* font-size: 18px; */
    }
    #nestable2 .dd-item>button{
        height: 42px;
        width: 42px;
        outline: none;
    }
</style>
<body class="gray-bg">
<div class="wrapper wrapper-content  animated fadeInRight">
    <div class="row">
        <div class="col-sm-4">
            <div id="nestable-menu">
                <button type="button" data-action="expand-all" class="btn btn-white btn-sm">展开所有</button>
                <button type="button" data-action="collapse-all" class="btn btn-white btn-sm">收起所有</button>
            </div>
        </div>
    </div>
    <div class="row category-box">
        <div class="ibox ">
            <div class="ibox-content">
                <div class="dd" id="nestable2">
                    <ol class="dd-list">
                        <?php foreach($provider as $k => $v){?>
                            <li class="dd-item dd-nodrag" data-id="<?=$v->id?>">
                                <div class="dd-handle">
                                    <p class="operating pull-right">
                                            <a class="btn-sm btn-info" href="<?=Url::toRoute(['menu/edit','parent_id' => $v->id])?>">
                                                <i class="fa fa-plus"></i> 添加
                                            </a>
                                            <a class="btn-sm btn-info" href="<?=Url::toRoute(['menu/edit','id' => $v->id])?>">
                                                <i class="fa fa-edit"></i> 编辑
                                            </a>
                                            <a class="btn-sm btn-danger" href="javascript:void(0);" onclick="del(<?= $v->id ?>)">
                                                <i class="fa fa-trash-o"></i> 删除
                                            </a>
                                    </p>
                                    <span class="label label-info"><i class="fa fa-cog"></i></span> <?=$v->name?>
                                </div>
                                <?=\backend\controllers\MenuController::setSon($v->id)?>
                            </li>
                        <?php } ?>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/admin/plugins/nestable/jquery.nestable.js"></script>
<script>
    $(document).ready(function(){

        $('#nestable2').nestable({group:1});
        $('.dd').on('change', function() {
            console.log($('.dd').nestable('serialize'));
        });
        $(".dd").nestable("collapseAll");
        $("#nestable-menu").on("click",function(e){var target=$(e.target),action=target.data("action");
            if(action==="expand-all"){
                $(".dd").nestable("expandAll")
            }
            if(action==="collapse-all"){
                $(".dd").nestable("collapseAll")
            }
        })
    });
</script>
<script type="text/javascript" src="http://tajs.qq.com/stats?sId=9051096" charset="UTF-8"></script>
</body>