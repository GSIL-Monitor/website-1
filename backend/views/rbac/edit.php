<?php
/**
 * @link http://www.shuwon.com/
 * @copyright Copyright (c) 2016 成都蜀美网络技术有限公司
 * @license http://www.shuwon.com/
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use kucha\ueditor\UEditor;
use yii\helpers\ArrayHelper;
\backend\assets\AppAsset::addScript($this, 'admin/scripts/template.js');

$p_cate = ArrayHelper::map(\common\models\Category::getParent('news',null,true),'cate_id','cate_title');
$type = Yii::$app->request->get('type')??$model->news_p_cate;
$span = $p_cate[$type];
$cate =  ArrayHelper::map(\common\models\Category::getSon($model->news_p_cate??$type),'cate_id','cate_title');
$span2 = $model->isNewRecord ? '创建' : '编辑';
$this->title = '后台首页';
$this->params['breadcrumbs'][] = '新闻' . $span2;
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?= $span.$span2 ?></h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> 首页</a></li>
        <li class="active"><?= $span.$span2  ?></li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="box col-md-12">
            <div class="box-inner">
                <div class="box-header" data-original-title="">

                </div>

                <div class="box-content">
                    <?php
                    $form = ActiveForm::begin([
                        'id' => 'edit-form'
                    ]);
                    ?>
                    <?= $form->field($model, 'news_id')->hiddenInput()->label(false) ?>
                    <?= $form->field($model, 'news_title')->textInput() ?>
                    <?= $form->field($model, 'news_abs')->textInput() ?>
                    <?= $form->field($model, 'news_author')->textInput(['style'=>'max-width:300px']) ?>
                    <?php $model->news_p_cate = $type?>
                    <div class="row" style="padding-left: 15px;">
                        <div class="col-md-4" style="padding-left: 0;">
                            <?= $form->field($model, 'news_p_cate')->inline()->dropDownList($p_cate, [
                                'prompt'=>'--请选择类别--',
                                'onchange'=>'getSon(this)',
                                'style'=>'max-width:300px'
                            ]) ?>
                        </div>

                        <div class="col-md-4" id="son_" style="padding-left: 0;<?=empty($cate)?'display:none':''?>">
                            <?= $form->field($model, 'news_cate')->inline()->dropDownList($cate, ['prompt' => '--请选择二级类别--','style'=>'max-width:300px']) ?>
                        </div>

                    </div>
                    <script id="temp_" type="text/html">
                        <option value="">--请选择二级类别--</option>
                        {{each data as value i}}
                        <option value="{{value.sc_id}}">{{value.school_title}}</option>
                        {{/each}}
                    </script>
                    <?= $form->field($model, 'news_face')->widget('shuwon\images\Webuploader') ?>
                    <?= $form->field($model, 'news_content')->widget(Ueditor::className()) ?>
                    <?= $form->field($model, 'created_at')->hiddenInput()->label(false) ?>
                    <?= $form->field($model, 'updated_at')->hiddenInput()->label(false) ?>
                    <?= $form->field($model, 'time')->textInput()->label('自定义时间(YYYY-mm-dd)') ?>
                    <?= $form->field($model, 'enabled')->inline()->radioList(Yii::$app->params['enabled']) ?>
                    <?= $form->field($model, 'recommend')->inline()->radioList(Yii::$app->params['recommend']) ?>
                    <?= $form->field($model, 'sort')->textInput() ?>
                    <?= $form->field($model, 'user_id')->hiddenInput()->label(false) ?>
                    <?= Html::submitButton('保存', ['class' => 'btn btn-primary']) ?>
                    <?php ActiveForm::end(); ?>
                    <br>
                </div>

            </div>
        </div>
    </div>
</section>
<script>
    function getSon(item) {
        $('#news-news_cate').html('<option value="">--请选择二级类别--</option>');
        $.ajax({
            url: "/admin/news/get-son",
            data: {cate_id: $(item).val()},
            type: 'post',
            async: false,
            success: function (res) {
                console.log(res)
                if (res.code==1){
                    var checkbox_ = template('temp_', res);
                    $('#news-news_cate').html(checkbox_);
                    $('#son_').show()
                }else {
                    $('#son_').hide()
                }

            }
        })
    }
</script>
<?php
$js = <<<JS
     $.datetimepicker.setLocale('ch');
     $("#edit-form").on('beforeSubmit',function(e){
        ajaxSubmitForm($(this));
        return false;
    });
     
JS;
$this->registerJs($js);
?>
