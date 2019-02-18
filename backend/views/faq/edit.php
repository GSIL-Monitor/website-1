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

$span = $model->isNewRecord ? '创建' : '编辑';
$this->title = '后台首页';
$this->params['breadcrumbs'][] = '问答专区' . $span;
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>问答专区<?= $span ?></h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> 首页</a></li>
        <li class="active">问答专区<?= $span ?></li>
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
                    <?= $form->field($model, 'news_bg')->textInput() ?>
                    <?= $form->field($model, 'news_cate')->dropDownList(\common\models\ProductType::getArray(), ['prompt' => '--请选择类别--'])->label('业务领域') ?>
                    <?= $form->field($model, 'news_content')->widget(Ueditor::className()) ?>
                    <?= $form->field($model, 'created_at')->hiddenInput()->label(false) ?>
                    <?= $form->field($model, 'updated_at')->hiddenInput()->label(false) ?>
                    <?= $form->field($model, 'enabled')->inline()->radioList(Yii::$app->params['enabled']) ?>
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
