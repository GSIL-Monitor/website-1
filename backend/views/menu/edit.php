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
$this->params['breadcrumbs'][] = '菜单' . $span;
\backend\assets\AppAsset::addScript($this, 'admin/scripts/template.js')
?>
    <!-- Content Header (Page header) -->
    <section class="content-header" style="margin-top: 50px;">
        <h1>菜单<?= $span ?></h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> 首页</a></li>
            <li class="active">菜单<?= $span ?></li>
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
                        <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
                        <?= $form->field($model, 'name')->textInput()->label('栏目名') ?>
                        <?= $form->field($model, 'module')->textInput()->label('模块名') ?>
                        <?= $form->field($model, 'controller')->textInput()->label('控制器') ?>
                        <?= $form->field($model, 'function')->textInput()->label('方法名') ?>
                        <?= $form->field($model, 'pid')->dropDownList(['0'=>'作为顶级分类'],['style'=>'max-width:500px'])->label('上级栏目') ?>
                        <script id="temp_" type="text/html">
                            <option value="0">作为顶级分类</option>
                            {{each data as value i}}
                            {{if value.id== <?=$model->pid?>}}
                            <option value="{{value.id}}" selected>{{value.str}}{{value.name}}</option>
                            {{ else }}
                            <option value="{{value.id}}">{{value.str}}{{value.name}}</option>
                            {{ /if}}
                            {{/each}}
                        </script>
                        <?= $form->field($model, 'parameter')->textInput()->label('参数') ?>
                        <?= $form->field($model, 'description')->textInput()->label('描述') ?>
                        <?= $form->field($model, 'icon')->textInput()->label('图标') ?>
                        <?= $form->field($model, 'is_open')->inline()->radioList(Yii::$app->params['enabled'])->label('默认展开') ?>
                        <?= $form->field($model, 'is_display')->inline()->radioList(Yii::$app->params['enabled'])->label('显示在右侧') ?>

                        <?= $form->field($model, 'created_at')->hiddenInput()->label(false) ?>
                        <?= $form->field($model, 'updated_at')->hiddenInput()->label(false) ?>
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
     $.ajax({
            url: "/admin/menu/menu",
            data: {},
            type: 'post',
            async: false,
            success: function (res) {
                if (res.code==1){
                    var checkbox_ = template('temp_', res);
                    $('#menu-pid').html(checkbox_);
            }
            }
        });
JS;
$this->registerJs($js);
?>