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
$this->params['breadcrumbs'][] = '信息编辑';
?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>信息编辑</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> 首页</a></li>
    <li class="active">信息编辑</li>
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
	                     'action' => Url::toRoute('config/edit'),
	                ]);
	                ?>
                <?= $form->field($model, 'config_id')->hiddenInput()->label(false) ?>
                <?= $form->field($model, 'config_title')->textInput() ?>
                <?= $form->field($model, 'config_key')->textInput() ?>
                <?= $form->field($model, 'config_type')->textInput() ?>
                <?= $form->field($model, 'config_dec')->textInput() ?>
                <?php if($model->config_id == 19||$model->config_id == 20){ ?>
                    <?= $form->field($model, 'config_value')->widget('shuwon\image\Webuploader')->label('二维码') ?>
                    <?php }else{?>
                    <?= $form->field($model, 'config_value')->textInput() ?>
                <?php }?>
                <?= $form->field($model, 'created_at')->hiddenInput()->label(false) ?>
                <?= $form->field($model, 'updated_at')->hiddenInput()->label(false) ?>
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
