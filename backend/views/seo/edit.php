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

$this->title = '后台首页';
$this->params['breadcrumbs'][] = 'SEO编辑';
?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>SEO编辑</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> 首页</a></li>
    <li class="active">SEO编辑</li>
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
	                     'id' => 'edit-form',
	                     'action' => Url::toRoute('seo/edit'),
	                ]);
	                ?>
                    <?= $form->field($model, 'seo_id')->hiddenInput()->label(false) ?>
                    <?= $form->field($model, 'title')->textInput(['readonly'=>true]) ?>
                    <?php if(Yii::$app->params['lang_str']=='cn'){ ?>
                            <?= $form->field($model, 'subtitle')->textInput()->label('标题(title)') ?>
                        <?= $form->field($model, 'keywords')->textInput()->label('关键字(keywords)') ?>
                        <?= $form->field($model, 'description')->textInput()->label('描述(description)') ?>
                    <?php }else{?>
                        <?= $form->field($model, 'subtitle_en')->textInput() ?>
                        <?= $form->field($model, 'description_en')->textInput() ?>
                    <?php }?>
                    <?= $form->field($model, 'created_at')->hiddenInput()->label(false) ?>
                    <?= $form->field($model, 'updated_at')->hiddenInput()->label(false) ?>
                    <?= $form->field($model, 'enabled')->hiddenInput()->label(false) ?>
                <?= $form->field($model, 'sort')->hiddenInput()->label(false) ?>
                    <?= $form->field($model, 'user_id')->hiddenInput()->label(false) ?>
                    <?= Html::submitButton('保存', ['class' => 'btn btn-primary']) ?>
	                <?php ActiveForm::end(); ?>
                	<br>
            </div>
            
        </div>
    </div>
</div>
</section>
<?php
$js=<<<JS
     $.datetimepicker.setLocale('ch');
     $("#edit-form").on('beforeSubmit',function(e){
        ajaxSubmitForm($(this));
        return false;
    });
JS;
$this->registerJs($js);
?>
