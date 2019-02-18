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
$this->params['breadcrumbs'][] = '网站信息';
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>网站信息</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> 首页</a></li>
        <li class="active">网站信息</li>
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
                    <?php foreach($configlist as $k => $v){ ?>
                        <div class="form-group field-config-config_value required">
                            <label class="control-label" for="config-config_value"><?=$v->config_title?></label>
                            <input type="text" id="config-config_value" class="form-control" name="Config_site[<?=$v->config_key?>]" value="<?=$v->config_value?>">
                            <p class="help-block help-block-error"></p>
                        </div>
                    <?php } ?>

                    <div class="form-group field-config-config_value required">
                        <label class="control-label" for="config-config_value">添加栏目关键词</label>
                        <?php foreach($key_list as $k => $v){ ?>

                            <div class="row" style="padding-left: 15px;">
                                <div class="col-md-3" style="padding-left: 0;">
                                    <div class="form-group field-config-config_value required">
                                        <label class="control-label" for="config-config_value">关键词</label>
                                        <input type="text" class="form-control" name="Config_k[]" value="<?=$v ?>" required>
                                        <p class="help-block help-block-error"></p>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group" style="padding-top: 24px;">
                                        <label class="control-label" for="config-config_value"></label>
                                        <a class="canclose btn btn-danger btn_" onclick="delcans($(this))"><i class="glyphicon glyphicon-trash icon-white"></i></a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="row" style="padding-left: 15px;margin-bottom: 15px;">
                            <a id="addcans" class="btn btn-info">添加新参数</a>
                        </div>
                    </div>

                    <?php foreach($configimgList as $k => $v){ ?>
                        <?= $form->field($model, 'config_key['.$v->config_key.']')->widget('shuwon\images\Webuploader')->label($v->config_title.('(1:1)')) ?>
                    <?php } ?>
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
     
     $('#addcans').click(function(){
        if(checkvalue()) return false;
        
        htmltext = '<div class="row" style="padding-left: 15px;">';
		htmltext += '	<div class="col-md-3" style="padding-left: 0;">'
        htmltext += '        <div class="form-group field-config-config_value required">'
        htmltext += '             <label class="control-label" for="config-config_value">关键词</label>'
        htmltext += '             <input type="text" class="form-control" name="Config_k[]" value="" required>'
        htmltext += '             <p class="help-block help-block-error"></p>'
        htmltext += '         </div>'
        htmltext += '    </div>'
        htmltext += ' <div class="col-md-1">' +
         '<div class="form-group" style="padding-top: 24px;">' +
          '<label class="control-label" for="config-config_value"></label>' +
           '<a class="canclose btn btn-danger" onclick="delcans($(this))"><i class="glyphicon glyphicon-trash icon-white"></i></a>' +
            '</div></div>'
        htmltext += '            </div>'
    	$(this).parent().before(htmltext);
    });
     
     function checkvalue(){
         var ischeck = false;
         $('.technology_content').each(function(){
             if($(this).val() == ''|| $(this).val() == null){
                 ischeck = true;
                 alert('请填写完内容之后再进行添加！！');
             }
         });
         return ischeck;
     }
     delcans=function(e){
    	e.parent().parent().parent().remove();
    }
   
     
     
JS;
$this->registerJs($js);
?>
