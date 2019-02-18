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
$this->params['breadcrumbs'][] = 'SEO添加';
?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>SEO添加</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> 首页</a></li>
    <li class="active">SEO添加</li>
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
	                     'id' => 'add-form',
	                     'action' => Url::toRoute('seo/add'),
	                ]);
	                ?>
                    <?= $form->field($model, 'seo_id')->hiddenInput()->label(false) ?>
                    <?= $form->field($model, 'title')->textInput() ?>
                <?= $form->field($model, 'subtitle')->textInput() ?>
                    <?= $form->field($model, 'keywords')->textInput() ?>
                    <?= $form->field($model, 'description')->textInput() ?>
                    <?= $form->field($model, 'created_at')->hiddenInput()->label(false) ?>
                    <?= $form->field($model, 'updated_at')->hiddenInput()->label(false) ?>

                    <?= $form->field($model, 'enabled')->inline()->radioList(Yii::$app->params['enabled']) ?>
                    <?php $model->enabled=1;?>
                    <?= $form->field($model, 'sort')->textInput(['value' => 0,'onkeyup' => 'value=value.replace(/[^\d]/g,"")']) ?>
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
     $("#add-form").on('beforeSubmit',function(e){
        ajaxSubmitForm($(this));
        return false;
    });
JS;
$this->registerJs($js);
?>
