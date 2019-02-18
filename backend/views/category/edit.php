<?php
//                              _(\_/)
//                             ,((((^`\         //+--------------------------------------------------------------
//                            ((((  (6 \        //|Copyright (c) 2017 http://www.shuwon.com All rights reserved.
//                          ,((((( ,    \       //+--------------------------------------------------------------
//      ,,,_              ,(((((  /"._  ,`,     //|Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
//     ((((\\ ,...       ,((((   /    `-.-'     //+--------------------------------------------------------------
//     )))  ;'    `"'"'""((((   (               //|Author: xww < xww@wyw1.cn >
//    (((  /            (((      \              //+--------------------------------------------------------------
//     )) |                      |
//    ((  |        .       '     |
//    ))  \     _ '      `t   ,.')
//    (   |   y;- -,-""'"-.\   \/
//    )   / ./  ) /         `\  \
//       |./   ( (           / /'                __     __ 
//       ||     \\          //'|                /  \~~~/  \
//       ||      \\       _//'||          ,----(     ..    ) 
//       ||       ))     |_/  ||         /      \__     __/   
//       \_\     |_/          ||       /|         (\  |(
//       `'"                  \_\     ^ \   /___\  /\ |  
//                            `'"        |__|   |__|-"
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use kucha\ueditor\UEditor;
use yii\helpers\ArrayHelper;

$span = $model->isNewRecord ? '创建' : '编辑';
$this->title = '后台首页';
$this->params['breadcrumbs'][] = '分类' . $span;
?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>分类<?= $span ?></h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> 首页</a></li>
            <li class="active">分类<?= $span ?></li>
        </ol>
    </section>
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
                        <?= $form->field($model, 'cate_id')->hiddenInput()->label(false) ?>
                        <?= $form->field($model, 'cate_title')->textInput() ?>
                        <?php if (Yii::$app->request->get('type') == 'news') { ?>
                            <?= $form->field($model, 'parent_id')->dropDownList(ArrayHelper::map(\common\models\Category::getParent(Yii::$app->request->get('type')), 'cate_id', 'cate_title'), ['prompt' => '顶级分类'])->label('选择顶级分类') ?>
                        <?php } else { ?>
                            <?php $model->parent_id = 0 ?>
                            <?= $form->field($model, 'parent_id')->hiddenInput()->label(false) ?>
                        <?php } ?>
                        <?= $form->field($model, 'thumb')->widget(shuwon\images\Webuploader::className()) ?>
                        <?php if ($model->isNewRecord) {
                            $model->enabled = 1;
                        } ?>
                        <?= $form->field($model, 'created_at')->hiddenInput()->label(false) ?>
                        <?= $form->field($model, 'updated_at')->hiddenInput()->label(false) ?>
                        <?= $form->field($model, 'enabled')->inline()->radioList(Yii::$app->params['enabled']) ?>
                        <?= $form->field($model, 'sort')->textInput() ?>

                        <?= $form->field($model, 'user_id')->hiddenInput()->label(false) ?>
                        <?= Html::submitButton('保存', ['class' => 'btn btn-primary']) ?>
                        <?php ActiveForm::end(); ?>
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