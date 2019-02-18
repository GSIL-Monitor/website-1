<?php
/**
 * @link http://www.shuwon.com/
 * @copyright Copyright (c) 2016 成都蜀美网络技术有限公司
 * @license http://www.shuwon.com/
 */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use backend\assets\AppAsset;
use yii\captcha\Captcha;
AppAsset::register($this);
$this->title=Yii::$app->params['AppName'];
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <?= Html::csrfMetaTags() ?>
  <title><?= Html::encode($this->title) ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <?php $this->head() ?>
</head>
<body class="hold-transition login-page">
<div class="reg-header"><a href="http://www.shuwon.com" target="_blank"><span>BETA 2.1</span></a></div>
<?php $this->beginBody() ?>
<div class="login-box">
  <div class="login-logo">
      <?= Html::encode($this->title) ?>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    
     <?php $form = ActiveForm::begin([
				'id' => 'login-form',
     ]);?>
     
      <?= $form->field($model, 'username',[
			'template'=>"<div class=\"form-group has-feedback\">{input}<span class=\"glyphicon glyphicon-user form-control-feedback\"></span></div>{error}"
	  ])->textInput(['placeholder'=>"请您输入账号"])->label("Username")?>
	  
	  <?= $form->field($model, 'password',[
		    'template'=>"<div class=\"form-group has-feedback\">{input}<span class=\"glyphicon glyphicon-lock form-control-feedback\"></span></div>{error}"
	  ])->passwordInput(['placeholder'=>"请您输入密码"])->label("Password") ?>

    <div id="embed-captcha" class="m-b35"></div>
    <div id="wait" class="show">正在加载验证码......</div>
    <div id="notice" class="hide" style="color:#dd4b39;">请先完成验证</div>

      <div class="row" style="padding-top:15px;">
        <div class="col-xs-6">
          <?= $form->field($model, 'rememberMe', [
					'template' => "<label>{input} Remember Me</label>",
					'options'=>['class'=>"checkbox icheck"],
                    'labelOptions'=>['style'=>"padding-left:0px;"],
				])->checkbox()->label('记住密码')?>
        </div>
        <!-- /.col -->
        <div class="col-xs-6">
          <?= Html::submitButton('登录', ['class' => 'btn btn-primary btn-block btn-flat login-btns','id'=>'embed-submit', 'name' => 'login-button']) ?>
        </div>
        <!-- /.col -->
      </div>
             
    <?php ActiveForm::end(); ?>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
<?php
 $js = <<<JS
    $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });




var handlerEmbed = function (captchaObj) {
        $("#embed-submit").click(function (e) {
            var validate = captchaObj.getValidate();
            if (!validate) {
                $("#notice")[0].className = "show";
                setTimeout(function () {
                    $("#notice")[0].className = "hide";
                }, 2000);
                e.preventDefault();
            }
        });
        // 将验证码加到id为captcha的元素里，同时会有三个input的值：geetest_challenge, geetest_validate, geetest_seccode
        captchaObj.appendTo("#embed-captcha");
        captchaObj.onReady(function () {
            $("#wait")[0].className = "hide";
        });
        // 更多接口参考：http://www.geetest.com/install/sections/idx-client-sdk.html
    };
    $.ajax({
        // 获取id，challenge，success（是否启用failback）
        url: "/admin/site/start/?t=" + (new Date()).getTime(), // 加随机数防止缓存
        type: "get",
        dataType: "json",
        success: function (data) {
            console.log(data);
            // 使用initGeetest接口
            // 参数1：配置参数
            // 参数2：回调，回调的第一个参数验证码对象，之后可以使用它做appendTo之类的事件
            initGeetest({
                gt: data.gt,
                challenge: data.challenge,
                new_captcha: data.new_captcha,
                product: "embed", // 产品形式，包括：float，embed，popup。注意只对PC版验证码有效
                offline: !data.success // 表示用户后台检测极验服务器是否宕机，一般不需要关注
                // 更多配置参数请参见：http://www.geetest.com/install/sections/idx-client-sdk.html#config
            }, handlerEmbed);
        }
    });


JS;
$this->registerJs($js);
?>
<?php $this->endBody() ?>
<script src="/admin/scripts/gt.js"></script>
</body>
</html>
<?php $this->endPage() ?>