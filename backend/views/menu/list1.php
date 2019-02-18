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
        <th>产品名称</th>
        <th>图片</th>
        <th>排序</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($provider->models as $list) { ?>
        <tr>
            <td class="center">
                <?= Html::encode($list->cate_title) ?></td>
            <td class="center">
                <img src="<?= Yii::getAlias('@static') ?>/<?= Html::encode($list->thumb) ?>" height="50"></td>
            <td class="center">
                <?= Html::encode($list->sort) ?></td>
            <td class="center" style="max-width: 70px">
                <a class="btn btn-info"
                   href='<?= Url::toRoute(['category/edit', 'id' => $list->cate_id,  'parent_id' => $parent_id, 'cate_id' => $cate_id]) ?>'>
                    <i class="glyphicon glyphicon-edit icon-white"></i>
                    编辑<?=$parent_id?>
                </a>
                <a class="btn btn-danger" href="javascript:void(0);" onclick='del(<?= $list->cate_id ?>)'>
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
