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

$type = Yii::$app->request->get('type');
$this->title = '后台首页';
$this->params['breadcrumbs'][] = $model->single_title . '编辑';
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?= $model->single_title ?>编辑 <?php if (in_array($type,['center-laboratory','1st-laboratory','2nd-laboratory','3rd-laboratory']) && !empty($model->single_title)){?><a href="<?= Url::toRoute(['img/index','type'=>$type]) ?>" class="btn btn-primary" style="margin-left: 20px;"><i class="glyphicon glyphicon-plus-sign"></i><span>图册列表</span></a><?php } ?></h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> 首页</a></li>
        <li class="active"><?= $model->single_title ?>编辑</li>
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
                        'action' => Url::toRoute('single/edit'),
                    ]);
                    ?>
                    <?= $form->field($model, 'single_id')->hiddenInput()->label(false) ?>
                    <?php if (empty($model->single_title)) { ?>
                        <?= $form->field($model, 'single_title')->textInput(/*['readonly' => true]*/) ?>
                    <?php } else { ?>
                        <?= $form->field($model, 'single_title')->textInput(['readonly' => true]) ?>
                    <?php } ?>
                    <?php if (in_array($model->type,['geometry-identify-calibration-of-measuring-instruments','large-geometric-precision-testing-machine-parts','large-cnc-machine-precision-detection','various-projects-geometrical-parameter-detection','technical-data-or-information-retrieval'])) { ?>
                        <?= $form->field($model, 'single_face')->widget('shuwon\images\Webuploader')->label('图标(100*100)') ?>
                        <?= $form->field($model, 'single_content')->widget(Ueditor::className()) ?>
                    <?php } else { ?>
                        <?= $form->field($model, 'single_content')->widget(Ueditor::className()) ?>
                    <?php } ?>
                    <?= $form->field($model, 'created_at')->hiddenInput()->label(false) ?>
                    <?= $form->field($model, 'updated_at')->hiddenInput()->label(false) ?>
                    <?= $form->field($model, 'enabled')->hiddenInput(['value' => 1])->label(false) ?>
                    <?= $form->field($model, 'type')->hiddenInput(['value' => $model->type])->label(false) ?>
                    <?= $form->field($model, 'sort')->hiddenInput(['value' => 0])->label(false) ?>
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
