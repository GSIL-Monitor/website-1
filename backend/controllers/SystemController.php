<?php
/**
 * @link http://www.shuwon.com/
 * @copyright Copyright (c) 2016 成都蜀美网络技术有限公司
 * @license http://www.shuwon.com/
 */
namespace backend\controllers;

use common\helpers\FileHelper;
use Yii;
use yii\web\Controller;
use \yii\helpers\Url;
/**
 * 系统管理控制器，用于后续升级和进行特殊管理。
 * @author 制作人
 * @since 1.0
 */
class SystemController extends CommonController {

    public function beforeAction($action) {
        $user = Yii::$app->user;
        if (!$user->isGuest && $user->identity->username == Yii::$app->params['SuperAdmin']) {
            return true;
        } else {
            echo '只有超级管理员能进行此项操作';
            return false;
        }
    }

	
    public function actionIndex() {
       //$this->insertPermission();
    }

    private function insertPermission() {
        $auth = Yii::$app->authManager; 
        
        $auth->removeAll();

        $p = $auth->createPermission('Info');//大写开头没有实际链接，为controller name
        $p->description = '基本信息';
        $auth->add($p);

        $p = $auth->createPermission('Seo');//大写开头没有实际链接，为controller name
        $p->description = 'SEO管理';
        $auth->add($p);
        
        $p = $auth->createPermission('Banner');
        $p->description = '首页banner管理';
        $auth->add($p);

        $p = $auth->createPermission('Sinbanner');
        $p->description = '内页banner管理';
        $auth->add($p);

        $p = $auth->createPermission('About');
        $p->description = '关于我们';
        $auth->add($p);

        $p = $auth->createPermission('News');
        $p->description = '新闻资讯';
        $auth->add($p);

        $p = $auth->createPermission('Fzdt');
        $p->description = '分站动态';
        $auth->add($p);

        $p = $auth->createPermission('Ywpd');
        $p->description = '业务频道';
        $auth->add($p);


        $p = $auth->createPermission('Jcsl');
        $p->description = '检测实力';
        $auth->add($p);

        $p = $auth->createPermission('Rcsl');
        $p->description = '人才实力';
        $auth->add($p);

        $p = $auth->createPermission('Hdjl');
        $p->description = '互动交流';
        $auth->add($p);

        $p = $auth->createPermission('Ztzl');
        $p->description = '专题专栏';
        $auth->add($p);

        $p = $auth->createPermission('Kfzx');
        $p->description = '客服中心';
        $auth->add($p);

        $p = $auth->createPermission('Lxwm');
        $p->description = '联系我们';
        $auth->add($p);

        $p = $auth->createPermission('User');
        $p->description = '权限管理';
        $auth->add($p);
        
    }

    private function writeConfig($key, $value) {
        $contents = file_get_contents('version.php');
        $contents = str_replace($this->loadConfig($key), $value, $contents);
        file_put_contents('version.php', $contents);
    }

    private function loadConfig($key) {
        $Config = require('version.php');
        return $Config[$key];
    }



}
