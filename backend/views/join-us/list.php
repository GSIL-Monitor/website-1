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

?>
<table id="" class="table table-striped table-bordered responsive">
    <thead>
    <tr>
        <th>标题</th>
        <th>描述</th>
        <th>推荐</th>
        <th>排序</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($provider->models as $list) { ?>
        <tr>
            <td class="center">
                <?= Html::encode($list->news_title) ?></td>
            <td class="center">
                <?= Html::encode($list->news_abs) ?></td>
            <td class="center">
                <?= Html::encode(Yii::$app->params['recommend'][$list->recommend]) ?></td>
            <td class="center">
                <?= Html::encode($list->sort) ?></td>
            <td class="center" style="max-width: 200px;min-width: 170px">
                <a class="btn btn-info"
                   href='<?= Url::toRoute(['join-us/edit', 'id' => $list->news_id]) ?>'>
                    <i class="glyphicon glyphicon-edit icon-white"></i>
                    编辑
                </a>
                <a class="btn btn-danger" href="javascript:void(0);" onclick='del(<?= $list->news_id ?>)'>
                    <i class="glyphicon glyphicon-trash icon-white"></i>
                    删除
                </a>
            </td>
        </tr>
    <?php } ?>    </tbody>
    <tfoot>
    <tr>
        <td colspan="20">
            <button class="btn btn-default pull-left" style="display: inline-block" disabled="disabled">
                (当前<?= $provider->count ?>条/共<?= $provider->totalCount ?>条)
            </button>
            <?=
            LinkPager::widget([
                'pagination' => $provider->pagination,
                'linkOptions' => ['onclick' => 'return goPage(this)'],
                'options' => ['class' => 'pagination pull-right', 'style' => 'margin:0px']
            ]);
            ?>
        </td>
    </tr>
    </tfoot>
</table>
<script type="text/javascript">
    $(function () {
        $('[data-toggle="popover"]').popover();
    })
</script>
