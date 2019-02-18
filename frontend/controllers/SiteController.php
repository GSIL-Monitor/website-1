<?php
/**
 * @link http://www.shuwon.com/
 * @copyright Copyright (c) 2016 成都蜀美网络技术有限公司
 * @license http://www.shuwon.com/
 */

namespace frontend\controllers;

use Yii;
use yii\helpers\VarDumper;
use yii\web\Controller;
use  yii\web\Session;
use yii\helpers\Url;

/**
 * 首页控制器。
 * @author 制作人
 * @since 1.0
 */
class SiteController extends Controller
{
    public $lang;
    public $layout;

    /*public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }*/
    public function init(){
        parent::init();
        $this->lang = Yii::$app->request->get('lang','cn');
        $this->lang = in_array($this->lang,Yii::$app->params['lang'])?$this->lang:'cn';
        $this->layout = '../'.$this->lang.'/layouts/main';
        Yii::$app->params['lang_str'] = $this->lang;
    }
    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null)              {
            return $this->renderpartial('/'.$this->lang.'/site/error', ['exception' => $exception]);
        }
    }

    /**
     *ie
     */
    public function actionIe()
    {
        return $this->renderpartial('/'.$this->lang.'/site/ie');
    }

    public function actionHeader()
    {
        return $this->renderpartial('/'.$this->lang.'/site/header');
    }

    public function actionFooter()
    {
        return $this->renderpartial('/'.$this->lang.'/home/footer');
    }

    public function actionStart()
    {
        /**
         * 使用Get的方式返回：challenge和capthca_id 此方式以实现前后端完全分离的开发模式 专门实现failback
         * @author Tanxu
         */
//error_reporting(0);
        require dirname(dirname(__FILE__)) . '/../vendor/gt3-php-sdk/class.geetestlib.php';
        require dirname(dirname(__FILE__)) . '/../vendor/gt3-php-sdk/config.php';
        $GtSdk = new \GeetestLib(CAPTCHA_ID, PRIVATE_KEY);
        $session = Yii::$app->session;
        $session->open();
        $data = array(
            "user_id" => "shuwon", # 网站用户id
            "client_type" => "web", #web:电脑上的浏览器；h5:手机上的浏览器，包括移动应用内完全内置的web_view；native：通过原生SDK植入APP应用的方式
            "ip_address" => $_SERVER["REMOTE_ADDR"] # 请在此处传输用户请求验证时所携带的IP
        );

        $status = $GtSdk->pre_process($data, 1);

        $session->set('gtserver', $status);
        $session->set('user_id', $data['user_id']);
        return $GtSdk->get_response_str();
    }

}
