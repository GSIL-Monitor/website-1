<?php
/**
 * @link http://www.shuwon.com/
 * @copyright Copyright (c) 2016 成都蜀美网络技术有限公司
 * @license http://www.shuwon.com/
 */
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\helpers\Url;
use yii\helpers\Json;
/**
 * 公共控制器，需要权限验证的都继承此控制器，在beforeAction验证权限。
 * @author 制作人
 * @since 1.0
 */
class CommonController extends Controller {

    public $lang;
    protected $models;


    public function actions(){
        return [
            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction',
            ]
        ];
    }
    
    /**
     * 构造函数 处理语言版本问题
    */
    public function init(){
        parent::init();
        // 语言版本处理  默认为中文
        $this->lang = Yii::$app->request->get('lang','cn');
        Yii::$app->params['lang_str'] = $this->lang;
    }



    public function beforeAction($action) {
        $auth=  Yii::$app->authManager;
        $isAjax = Yii::$app->request->getIsAjax();
       
        //未登录
        if (Yii::$app->user->isGuest) {
            if ($isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                Yii::$app->response->data = array(
                    'status' => -1,
                    'message' => '请先登录',
                    'url' => Yii::$app->getHomeUrl()
                );
                return false;
            } else {
                return $this->goHome();
            }
        }
        //超级管理员
        if(Yii::$app->user->identity->username==Yii::$app->params['SuperAdmin']){
            return true;
        }
        //return true;//调试
        //controller id 和 action id 组成节点，判断有否有权操作
        $action = Yii::$app->controller->id;
        //$action=  strtolower($action);//转成小写
        if(!$auth->getPermission($action)){
            //该页面没有纳入权限管理
            return true;
        }
        if (!\Yii::$app->user->can($action)) {
            if ($isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                Yii::$app->response->data = array(
                    'status' => -1,
                    'message' => '对不起,你无权进行此项操作',
                );
                return false;
            } else {
                throw new \yii\web\HttpException(403, '对不起，您现在还没获此操作的权限');
            };
        } else {
            return parent::beforeAction($action);
        }
    }

    public function renderJson($params = array()) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $params;
    }
    
    /**
     * desription 压缩图片
     * @param sting $imgsrc 图片路径
     * @param string $imgdst 压缩后保存路径
     */
    public function image_png_size_add($imgsrc,$imgdst){
        list($width,$height,$type)=getimagesize($imgsrc);
        $new_width = ($width>1248?1248:$width)*0.9;
        $new_height = ($height>1755?1755:$height)*0.9;
        switch($type){
            case 1:
                $giftype=$this->check_gifcartoon($imgsrc);
                if($giftype){
                    header('Content-Type:image/gif');
                    $image_wp=imagecreatetruecolor($new_width, $new_height);
                    $image = imagecreatefromgif($imgsrc);
                    imagecopyresampled($image_wp, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                    imagejpeg($image_wp, $imgdst,75);
                    imagedestroy($image_wp);
                }
                break;
            case 2:
                header('Content-Type:image/jpeg');
                $image_wp=imagecreatetruecolor($new_width, $new_height);
                $image = imagecreatefromjpeg($imgsrc);
                imagecopyresampled($image_wp, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                imagejpeg($image_wp, $imgdst,75);
                imagedestroy($image_wp);
                break;
            case 3:
                header('Content-Type:image/png');
                $image_wp=imagecreatetruecolor($new_width, $new_height);
                $image = imagecreatefrompng($imgsrc);
                imagecopyresampled($image_wp, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                imagejpeg($image_wp, $imgdst,75);
                imagedestroy($image_wp);
                break;
        }
        return true;
    }
    
    /**
     * desription 判断是否gif动画
     * @param sting $image_file图片路径
     * @return boolean t 是 f 否
     */
    public function check_gifcartoon($image_file){
        $fp = fopen($image_file,'rb');
        $image_head = fread($fp,1024);
        fclose($fp);
        return preg_match("/".chr(0x21).chr(0xff).chr(0x0b).'NETSCAPE2.0'."/",$image_head)?false:true;
    }


    /**
     * 返回模型
     *
     * @param $id
     * @return $this|Article|static
     */

    protected function findModel($id = null)
    {
        $modules = $this->models;           // 获取继承类获取的模型状态
        if (empty($id))
        {
            $model = new $modules;
            return $model->loadDefaultValues();
        }
        if (empty(($model = $modules::findOne($id))))
        {
            $model = new $modules;
            return $model->loadDefaultValues();
        }

        return $model; // 返回数据模型
    }
}
