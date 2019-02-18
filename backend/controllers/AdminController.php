<?php
/**
 * @link http://dytl.shuwon.com/
 * @copyright Copyright (c) 2016 成都蜀美网络技术有限公司
 * @license http://dytl.shuwon.com/
 */
namespace backend\controllers;

use common\helpers\FileHelper;
use common\helpers\ServerInfo;
use common\models\Config;
use common\models\News;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use backend\models\User;
use yii\helpers\Url;

/**
 * 后台首页控制器
 * @author 制作人
 * @since 1.0
 */
class AdminController extends CommonController{
    
    public function actionIndex() {
       return $this->render('index');
    }
    /**
     * 系统信息
     */
    public function actionInfo()
    {
        $db = Yii::$app->db;
        $models = $db->createCommand('SHOW TABLE STATUS')->queryAll();
        $models = array_map('array_change_key_case', $models);

        // 数据库大小
        $mysql_size = 0;
        foreach ($models as $model)
        {
            $mysql_size += $model['data_length'];
        }

        // 禁用函数
        $disable_functions = ini_get('disable_functions');
        $disable_functions = !empty($disable_functions) ? $disable_functions : '未禁用';

        // 附件大小
        $attachment_size = FileHelper::getDirSize(Yii::getAlias('@attachment'));
        return $this->render('info', [
            'models' => Menu::getMenus(Menu::TYPE_SYS, StatusEnum::ENABLED),
            'mysql_size' => $mysql_size,
            'attachment_size' => !empty($attachment_size) ? $attachment_size : 0,
            'disable_functions' => $disable_functions,
        ]);
    }
    public function actionProfile() {
        $model = new User(['scenario' => 'editprofile']);
        return $this->render('profile', [
                    'model' => $model
        ]);
    }
    public function actionEditprofile() {
        $model = new User(['scenario' => 'editprofile']);
        $result = array();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->editProfile(\Yii::$app->user->identity->id)) {
                $result['status'] = 1;
                $result['message'] = '保存成功，请重新登录';
                $result['url'] = Url::toRoute('site/logout');
            }
        }
        $errors = $model->getFirstErrors();
        if ($errors) {
            $result['status'] = 0;
            $result['message'] = current($errors);
        }
        return $this->renderJson($result);
    }
    public function actionClear()
    {
        $res = Config::findOne(['config_key'=>'resource_version']);
        if(!empty($res)){
            $res->config_value = rand(100,999)/1000;
        }else{
            $res = new Config();
            $res->config_title = '资源版本号';
            $res->config_key = 'resource_version';
            $res->config_type = 'resource';
            $res->config_value = rand(100,999)/1000;
            $res->created_at = time();
            $res->updated_at = time();
            $res->enabled = 1;
        }
        if ($res->save()){
            $result['status'] = 1;
            $result['message'] = '清除缓存成功';
        }else{
            $result['status'] = 0;
            $result['message'] = '清除缓存失败';
        }
        return $this->renderJson($result);
    }
    public function actionSitemap()
    {

        $hostInfo=Yii::app()->request->hostInfo;
        $xml = '<?xml version="1.0" encoding="utf-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        $xml .='<url>';
        $xml .='<loc>'.$hostInfo.'</loc>';
        $xml .='<lastmod>2018-10-23</lastmod>';
        $xml .='<changefreq>daily</changefreq>';
        $xml .='<priority>1.0</priority>';
        $xml .='</url>';

        $news =News::find()->where(['enabled'=>1])->orderBy('sort desc,news_id desc')->all();
        foreach ($news as $k=>$v) {
            if ($v->news_type=='news'){
                $url=$hostInfo.'/newsinfo/'.$v->news_id.'.html';
            }else{
                $url=$hostInfo;
            }

            $xml .='<url>';
            $xml .='<loc>'.$url.'</loc>';
            $xml .='<lastmod>'.date('Y-m-d',$v->created_at).'</lastmod>';
            $xml .='<changefreq>daily</changefreq>';
            $xml .='<priority>1.0</priority>';
            $xml .='</url>';

        }

        $xml .= '</urlset>';


        file_put_contents('../sitemap.xml',$xml) ;
        $result['status'] = 1;
        $result['message'] = '成功更新网站地图';
        return $this->renderJson($result);
    }
}
