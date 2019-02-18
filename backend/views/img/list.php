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
$url = Url::toRoute(['img/edit','type'=>$type])
?>

    <?=ListView::widget([
        'provider'    => $provider,
        'listType'  => 'ImgList',
        'id'        => 'img_id',
        'action'    => 'img/edit',
        'item'      => [
            'face'      => 'img_face',
            'title'     => 'img_title',
            'height'    => '200'
        ],
    ])?>
<script type="text/javascript">
    $(function(){
        $('[data-toggle="popover"]').popover();
    })
</script>
