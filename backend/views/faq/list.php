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
use backend\widgets\ListView;

?>


<?=ListView::widget([
    'provider'    => $provider,
    'action'      => 'faq/edit',
    'id'        => 'news_id',
    'item'      => [
        'news_title' => [
            'value' => '标题',
            'type'  => 'text'
        ],
        'news_cate' => [
            'value'     => '业务领域',
            'type'      => 'dropDown',
            'dataArr'   => \common\models\ProductType::getArray()
        ],
        'enabled'   => [
            'value' => '审核',
            'type'  => 'dropDown',
            'dataArr'   => Yii::$app->params['enabled']
        ],
        'sort'      => [
            'value' => '排序',
            'type'  => 'text'
        ]
    ]
])?>

<script type="text/javascript">
    $(function(){
        $('[data-toggle="popover"]').popover();
    })
</script>
