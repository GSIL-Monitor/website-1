<?php
/**
 * @link http://www.shuwon.com/
 * @copyright Copyright (c) 2016 成都蜀美网络技术有限公司
 * @license http://www.shuwon.com/
 */

namespace backend\controllers;

use common\models\ProductType;
use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\data\ActiveDataProvider;
use common\models\Faq;

/**
 * 新管理控制器。
 * @author 制作人
 * @since 1.0
 */
class FaqController extends CommonController
{

    public function init()
    {
        parent::init();
        $this->models =Faq::className();            // 设置改站点默认模型 用于获取数据
    }

    /**
     * 主页面
     */
    public function actionIndex()
    {
        $pro_type=[];
        $pro_type = ProductType::find()->where(['enabled'=>1,'news_type'=>'producttype'])->orderBy('sort desc,news_id desc')->asArray()->all();
        $cate_id = Yii::$app->request->get('cate_id');
        if(empty($cate_id) && count($pro_type)>0){
            $cate_id=$pro_type[0]['news_id'];
        }
        return $this->render('index', [
            'model' => $this->findModel(),
            'pro_type' =>$pro_type,
            'cate_id' =>$cate_id,
        ]);
    }

    /**
     * 编辑/新增
     */

    public function actionEdit()
    {
        $id = Yii::$app->request->get('id');        // 获取编辑id  不存在则为新增状态
        $model = $this->findModel($id);                // 获取模型
        // echoll($model);
        if (Yii::$app->request->getIsPost()) {
            $result['status'] = 1;
            $model->news_type = 'faq';

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                $result['message'] = '保存成功';
                $result['url'] = Url::toRoute('faq/index');
            }
            $errors = $model->getFirstErrors();
            if ($errors) {
                $result['status'] = 0;
                $result['message'] = current($errors);
            }
            return $this->renderJson($result);
        } else {
            return $this->render('edit', [
                'model' => $model
            ]);
        }
    }

    public function actionList()
    {
        $pro_type = ProductType::find()->where(['enabled'=>1,'news_type'=>'producttype'])->orderBy('sort desc,news_id desc')->asArray()->all();
        $cate_id = Yii::$app->request->get('cate_id');
        if(empty($cate_id) && count($pro_type)>0){
            $cate_id=$pro_type[0]['news_id'];
        }

        $query = Faq::find();
        $query->where(['news_type' => 'faq']);
        $query->andWhere(['lang' => $this->lang]);
        $query->andFilterWhere(["like", "news_title", Yii::$app->request->get("news_title")]);
        $query->andFilterWhere(["news_cate" => $cate_id]);
        $query->andFilterWhere(["enabled" => Yii::$app->request->get("enabled")]);
        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'sort' => SORT_DESC,
                    'news_id' => SORT_DESC,
                ]
            ],
        ]);
        return $this->renderPartial('list', ['provider' => $provider]);
    }

    public function actionDel($id)
    {
        $result = array();
        if ($this->findModel($id)->delete()) {
            $result['status'] = 1;
            $result['message'] = '删除成功';
        } else {
            $result['status'] = 0;
            $result['message'] = '删除失败';
        }
        return $this->renderJson($result);
    }
}