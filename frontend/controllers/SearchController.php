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
use yii\sms\Sms;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use common\models\News;
use yii\data\ActiveDataProvider;

/**
 * 需控制器。
 * @author 制作人
 * @since 1.0
 */
class SearchController extends CommonController {
	public function actionIndex(){
        $this->getseo(4);
        $keywords = Yii::$app->request->get('keywords');
        $data['keywords'] = $keywords;
        $keywords = '%'.$keywords.'%';
        $query = News::find();
        $query->where("`news_title` LIKE :keywords OR `news_abs` LIKE :keywords")->addParams([':keywords'=>$keywords]);
        /*echo "<pre>";
        var_dump($list);exit;*/
        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 6,
            ],
            'sort' => [
                'defaultOrder' => [
                    'sort' => SORT_DESC,
                    'news_id' => SORT_DESC,
                ]
            ],
        ]);
        $data['page'] = Yii::$app->request->get('page');
        $data['count'] = $query->count();
        $data['provider'] = $provider;
		return $this->render('index',$data);
	}

}