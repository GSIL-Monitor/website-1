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
        'listType'  => 'ImgList',
        'id'        => 'seo_id',
        'action'    => 'banner/edit',
        'item'      => [
            'face'      => 'banner_face',
            'title'     => 'title'
            
        ],
    ])?>
<script type="text/javascript">
    $(function(){
        $('[data-toggle="popover"]').popover();
    })
</script>
