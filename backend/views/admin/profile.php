<?php
/**
 * @link http://www.shuwon.com/
 * @copyright Copyright (c) 2016 成都蜀美网络技术有限公司
 * @license http://www.shuwon.com/
 */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = '后台首页';
$this->params['breadcrumbs'][] = '更改资料';
?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>更改资料</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> 首页</a></li>
    <li class="active">更改资料</li>
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
                        'id'=>'editProfile-form',
                        'action'=> Url::toRoute('admin/editprofile')
                    ]);
                    ?>
                        <?= $form->field($model, 'password')->passwordInput()->label("旧密码")?>
                        <?= $form->field($model, 'newPassword')->passwordInput() ?>
                        <?= $form->field($model, 'verifyNewPassword')->passwordInput() ?>
                        <?= Html::submitButton('保存', ['class' => 'btn btn-primary']) ?>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
$js=<<<JS
    $("#editProfile-form").on('beforeSubmit',function(e){
        ajaxSubmitForm($(this));
        return false;
    });
JS;
$this->registerJs($js);
?>