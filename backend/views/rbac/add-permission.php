<?php

use \yii\bootstrap\ActiveForm;
use \yii\bootstrap\Html;
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>权限添加</h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> 首页</a></li>
    <li class="active">权限添加</li>
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

                    <?= $form->field($model, 'name')->textInput() ?>
                    <?= $form->field($model, 'description')->textInput() ?>

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
