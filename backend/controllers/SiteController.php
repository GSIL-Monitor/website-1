<?php
/**
 * @link http://www.shuwon.com/
 * @copyright Copyright (c) 2016 成都蜀美网络技术有限公司
 * @license http://www.shuwon.com/
 */
namespace backend\controllers;

use common\models\Adminlog;
use common\models\Config;
use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use backend\models\User;
/**
 * 首页控制器。
 * @author 制作人
 * @since 1.0
 */
class SiteController extends Controller{

    public function actions(){
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'width' => 120,
                'height' => 40,
                'padding' => 0,
                'minLength' => 4,
                'maxLength' => 4,
            ],
            'image' => [
                'class' => \shuwon\images\Action::className()
            ],
            'file' => [
                'class' => \shuwon\file\Action::className()
            ],
            'audio' => [
                'class' => \shuwon\audio\Action::className()
            ],
            'video' => [
                'class' => \shuwon\video\Action::className()
            ],
        ];
    }
	public function actionStart(){
		require dirname(dirname(__FILE__)).'/../vendor/gt3-php-sdk/class.geetestlib.php';
        require dirname(dirname(__FILE__)).'/../vendor/gt3-php-sdk/config.php';
        $GtSdk = new \GeetestLib(CAPTCHA_ID, PRIVATE_KEY);
       
        $data = array(
            "user_id" => "shuwon", # 网站用户id
            "client_type" => "web", #web:电脑上的浏览器；h5:手机上的浏览器，包括移动应用内完全内置的web_view；native：通过原生SDK植入APP应用的方式
            "ip_address" => $_SERVER["REMOTE_ADDR"] # 请在此处传输用户请求验证时所携带的IP
        );

        $status = $GtSdk->pre_process($data, 1);

		Yii::$app->session['gtserver'] = $status;
		Yii::$app->session['user_id'] = $data['user_id'];
     
        echo $GtSdk->get_response_str();
    }
    public function actionIndex(){
        Yii::$app->controller->layout = false;
        if (!\Yii::$app->user->isGuest) {

            $this->redirect(Url::toRoute('admin/index')); //已登录直接跳转
        }
        $model = new User(['scenario' => 'login']);
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $this->log($model);
            return $this->redirect(Url::toRoute('admin/index'));
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogin(){
        Yii::$app->controller->layout = false;
        if (!\Yii::$app->user->isGuest) {
            $this->redirect(Url::toRoute('admin/index')); //已登录直接跳转
        }
        $model = new User(['scenario' => 'login']);
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $this->log($model);
            return $this->redirect(Url::toRoute('admin/index'));
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }
    public function log($user){
        if($user){
            $log = new Adminlog();
            $log->username=$user->username;
            $log->user_id=empty($user->id)?'':$user->id;
            $log->log_cate='登录成功！';
            $log->ip=$_SERVER["REMOTE_ADDR"];

            $log->save(false);
        }

    }
    public function actionLogout(){
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
