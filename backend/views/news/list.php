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
    'action'      => 'news/edit',
    'id'        => 'news_id',
    'item'      => [
        'news_title' => [
            'value' => '标题',
            'type'  => 'text'
        ],
        'news_p_cate' => [
            'value'     => '新闻类型',
            'type'      => 'dropDown',
            'dataArr'   => \yii\helpers\ArrayHelper::map(\common\models\Category::getParent('news'),'cate_id','cate_title')
        ],
        'news_cate' => [
            'value'     => '分站',
            'type'      => 'dropDown',
            'dataArr'   => \yii\helpers\ArrayHelper::map(\common\models\Category::getSon(14),'cate_id','cate_title')
        ],
        'news_face' => [
            'value' => '封面',
            'type'  => 'image'
        ],
        'recommend' => [
            'value' => '推荐',
            'type'  => 'dropDown',
            'dataArr' => Yii::$app->params['recommend']
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
