<?php
/**
 * @link http://www.shuwon.com/
 * @copyright Copyright (c) 2016 成都蜀美网络技术有限公司
 * @license http://www.shuwon.com/
 */
namespace backend\controllers;

use Yii;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\data\ActiveDataProvider;
use common\models\Config;
/**
 * 设管理控制器。
 * @author 制作人
 * @since 1.0
 */
class ConfigController extends CommonController {

    /**
     * 配置修改
     */
    public function actionIndex(){
        $configList = Config::find()->where(['enabled' => 1,'config_type' => 'web_site','lang'=>Yii::$app->params['lang_str']])->orderby('sort desc,config_id asc')->all();   // 普通配置数据
        $configimgList = Config::find()->where(['enabled' => 1,'config_type' => 'web_img_site','lang'=>Yii::$app->params['lang_str']])->orderby('sort desc,config_id asc')->all();    // 图片配置数据

        $model = new Config();
        $arr = [];
        foreach($configimgList as $k => $v){
            $arr[$v->config_key] = $v->config_value;    // 处理图片配置数据
        }

        $model->config_key = $arr;
        return $this->render('index', [
            'configlist' => $configList,                // 文本内容配置
            'configimgList' => $configimgList,          // 图片内容配置
            'model'     => $model,
        ]);
    }

    public function actionEdit(){
        $data = Yii::$app->request->post('Config_site');
        $img_data = Yii::$app->request->post('Config');
        $key_data = Yii::$app->request->post('Config_k');

        foreach($data as $k => $v){
            $models = Config::find()->where(['enabled' => 1,'config_key' => $k,'config_type' => 'web_site','lang'=>Yii::$app->params['lang_str']])->One();
            if($models){
                $models->config_value = $v;
                $models->save();
            }
        }
        foreach($img_data['config_key'] as $k => $v){
            $models = Config::find()->where(['enabled' => 1,'config_key' => $k,'config_type' => 'web_img_site','lang'=>Yii::$app->params['lang_str']])->One();
            if($models){
                $models->config_value = $v;
                $models->save();
            }
        }
        //关键字设置
        $keyword = empty($key_data)?'':('|'.implode('|',$key_data).'|');
        if(!empty($keyword)){
            $models = Config::find()->where(['config_key' => 'web_site_keywords'])->One();
            $models->config_value = $keyword;
            $models->save();
        }
        $result['status'] = 1;
        $result['message'] = '修改成功！！';
        $result['url'] = Url::toRoute('config/index');
        return $this->renderJson($result);
    }
}