<?php
/**
 * @link http://www.shuwon.com/
 * @copyright Copyright (c) 2016 成都蜀美网络技术有限公司
 * @license http://www.shuwon.com/
 */
namespace backend\models;

use common\models\Adminlog;
use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use  yii\web\Session;
/**
 * @author 制作人
 * @since 1.0
 */
class User extends ActiveRecord implements IdentityInterface {

    //登录时使用，记住我和验证码
    public $rememberMe = false;
    public $verifyCode;
    //用户更改资料时使用
    public $newPassword; //新密码
    public $verifyNewPassword; //确认用户密码

    public static function tableName() {
        return 'user';
    }

    public function attributeLabels() {
        return [
            'username' => '用户名',
            'password' => '密码',
            'newPassword' => '新密码',
            'verifyNewPassword' => '确认新密码'
        ];
    }

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->auth_key = Yii::$app->security->generateRandomString(); //自动添加随机auth_key
                $this->password = Yii::$app->security->generatePasswordHash($this->password); //密码加密
                $this->created_at = time();
                $this->updated_at = time();
                $this->enabled = 1;
            }
            return true;
        }
        return false;
    }

    public function rules() {
        return [
            //通用
            [['username', 'password', 'newPassword', 'verifyNewPassword'], 'trim'], //去两端空格
            //登录场景
            [['username', 'password'], 'required', 'on' => 'login'], //必填
            //['verifyCode', 'captcha', 'on' => 'login'], //验证码
            ['password', 'validatePassword', 'on' => 'login'], //调用validatePassword
            ['username', 'string', 'length' => [2, 10], 'on' => 'login'], //长度验证
            ['password', 'string', 'length' => [4, 12], 'on' => 'login'],
            ['rememberMe', 'boolean', 'on' => 'login'], //是否
            //修改资料场景
            [['username', 'password', 'newPassword', 'verifyNewPassword'], 'required', 'on' => 'editprofile'], //必填
            ['username', 'string', 'length' => [2, 10], 'on' => 'editprofile'], //长度验证
            [['password', 'newPassword', 'verifyNewPassword'], 'string', 'length' => [4, 12], 'on' => 'editprofile'], 
            ['verifyNewPassword', 'compare', 'compareAttribute' => 'newPassword', 'message' => '请重复输入新密码', 'on' => 'editprofile'], //newPassword与verifyNewPassword是否相同
        ];
    }

    public function scenarios() {
        $scenarios = parent::scenarios();
        $scenarios['login'] = ['username', 'password', 'rememberMe', 'verifyCode'];
        $scenarios['editprofile'] = ['password', 'newPassword', 'verifyNewPassword'];
        return $scenarios;
    }

    /**
     * Finds an identity by the given ID.
     *
     * @param string|integer $id the ID to be looked for
     * @return IdentityInterface|null the identity object that matches the given ID.
     */
    public static function findIdentity($id) {
        return static::findOne($id);
    }

    //根据用户名查找用户
    public static function findByUsername($username) {
        return static::findOne(['username' => $username]);
    }

    /**
     * Finds an identity by the given token.
     *
     * @param string $token the token to be looked for
     * @return IdentityInterface|null the identity object that matches the given token.
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * @return int|string current user ID
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return string current user auth key
     */
    public function getAuthKey() {
        return $this->auth_key;
    }

    /**
     * @param string $authKey
     * @return boolean if auth key is valid for current user
     */
    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }

    public function validatePassword($attribute, $params) {
        if (!$this->hasErrors()) {
            $user = static::findByUsername($this->username);
            if (!$user || !\Yii::$app->security->validatePassword($this->password, $user->password)) {
                $this->addError($attribute, '用户名或者密码错误');

                //登录失败写入日志
                if($user && !\Yii::$app->security->validatePassword($this->password, $user->password)){
                    $this->log($user);
                }else{
                    $this->log($this);
                }

            }elseif($user&&$user->enabled==false){
                $this->addError($attribute, '账户已经禁用');
                $this->log($user);
            }


        }
    }
    public function log($user){
        if($user){
            $log = new Adminlog();
            $log->username=$user->username;
            $log->user_id=empty($user->id)?'':$user->id;
            $log->log_cate='登录失败！';
            $log->ip=$_SERVER["REMOTE_ADDR"];
            if(!empty($user->id)){
                if($user->enabled==false){
                    $log->type='禁用账号登录！';
                }else{
                    $log->type='密码错误！';
                }
            }else{
                $log->type='账户不存在！';
            }


            $log->save(false);
        }

    }
    public function login() {
       //图形验证码验证
        /**
         * 输出二次验证结果,本文件示例只是简单的输出 Yes or No
         */
         //error_reporting(0);
        require dirname(dirname(__FILE__)).'/../vendor/gt3-php-sdk/class.geetestlib.php';
        require dirname(dirname(__FILE__)).'/../vendor/gt3-php-sdk/config.php';

        $GtSdk = new \GeetestLib(CAPTCHA_ID, PRIVATE_KEY);
        //print_r(Yii::$app->session['gtserver']);die();

        $data = array(
            "user_id" => Yii::$app->session['user_id'], # 网站用户id
            "client_type" => "web", #web:电脑上的浏览器；h5:手机上的浏览器，包括移动应用内完全内置的web_view；native：通过原生SDK植入APP应用的方式
            "ip_address" => $_SERVER["REMOTE_ADDR"] # 请在此处传输用户请求验证时所携带的IP
        );

		 if (Yii::$app->session['gtserver'] == 1) {   //服务器正常
            $result = $GtSdk->success_validate($_POST['geetest_challenge'], $_POST['geetest_validate'], $_POST['geetest_seccode'], $data);
            if ($result) {
                //echo '{"status":"success"}';
            } else{
                //echo '{"status":"fail"}';die();
				
                return false;
            }
        }else{  //服务器宕机,走failback模式
            if ($GtSdk->fail_validate($_POST['geetest_challenge'],$_POST['geetest_validate'],$_POST['geetest_seccode'])) {
               // echo '{"status":"success"}';
            }else{
                //echo '{"status":"fail1"}';die();
                return false;
            }
        }

        //yii

        if ($this->validate()) {
            return Yii::$app->user->login(static::findByUsername($this->username), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }

    public function editProfile($id) {
        $user = User::findIdentity($id);
        if ($user) {
            if ($this->validate()) {
                if (\Yii::$app->security->validatePassword($this->password, $user->password)) {
                    $user->password = Yii::$app->security->generatePasswordHash($this->newPassword);
                    if ($user->save()) {
                        return true;
                    } else {
                        $this->addError('username', '更新数据出错');
                        return false;
                    }
                } else {
                    $this->addError('password', '旧密码错误');
                    return false;
                }
            } else {
                return false;
            }
        } else {
            $this->addError('username', '未找到该用户');
            return false;
        }
    }

}
