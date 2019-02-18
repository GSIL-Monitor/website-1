<?php
/**
 * @link http://www.shuwon.com/
 * @copyright Copyright (c) 2016 成都蜀美网络技术有限公司
 * @license http://www.shuwon.com/
 */

namespace backend\controllers;

use common\models\Category;
use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\data\ActiveDataProvider;
use common\models\News;

/**
 * 新管理控制器。
 * @author 制作人
 * @since 1.0
 */
class NewsController extends CommonController
{

    public function init()
    {
        parent::init();
        $this->models = \common\models\News::className();            // 设置改站点默认模型 用于获取数据
    }

    /**
     * 主页面
     */
    public function actionIndex()
    {
        return $this->render('index', [
            'model' => $this->findModel(),
            'type'=>Yii::$app->request->get('type')
        ]);
    }

    /**
     * 编辑/新增
     */

    public function actionEdit()
    {
        $id = Yii::$app->request->get('id');        // 获取编辑id  不存在则为新增状态
        $model = $this->findModel($id);                // 获取模型
        $type = Yii::$app->request->get('type');
        if (Yii::$app->request->getIsPost()) {
            $result['status'] = 1;
            $model->news_type = 'news';
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                $result['message'] = '保存成功';
                $result['url'] = Url::toRoute(['news/index','type'=>$model->news_p_cate]);
            }
            $errors = $model->getFirstErrors();
            if ($errors) {
                $result['status'] = 0;
                $result['message'] = current($errors);
            }
            return $this->renderJson($result);
        } else {
            return $this->render('edit', [
                'model' => $model,
            ]);
        }
    }

    public function actionList()
    {
        $query = News::find();
        $query->where(['news_type' => 'news']);
        $query->andWhere(['lang' => $this->lang]);
        $query->andFilterWhere(["like", "news_title", Yii::$app->request->get("news_title")]);
        $query->andFilterWhere(["news_p_cate" => Yii::$app->request->get("type")]);
        $query->andFilterWhere(["enabled" => Yii::$app->request->get("enabled")]);
        $query->andFilterWhere(["recommend" => Yii::$app->request->get("recommend")]);
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


    public function actionGotop($id) {
        $result = array();
        $model = News::findOne($id);
        $model_sort =$model->sort;
        $model1 = News::find()->orderby('sort desc')->one();
        $model1_sort =$model1->sort+1;
        $model->sort=$model1_sort;
        $model->save(false);

        $result['status'] = 1;
        $result['message'] = '设置成功';
        return $this->renderJson($result);
    }
    public function actionTopremove($id) {
        $result = array();
        $model = News::findOne($id);
        $model_sort =$model->sort;
        $model1 = News::find()->andFilterWhere(['>', 'sort', $model_sort])->orderby('sort asc,news_id asc')->one();
        $model1_sort =$model1->sort;
        $model->sort=$model1_sort;
        $model->save(false);
        $model1->sort=$model_sort;
        $model1->save(false);

        $result['status'] = 1;
        $result['message'] = '设置成功';
        return $this->renderJson($result);
    }
    public function actionBottom($id) {
        $result = array();
        $model = News::findOne($id);
        $model_sort =$model->sort;
        $model1 = News::find()->andFilterWhere(['<', 'sort', $model_sort])->orderby('sort desc')->one();

        $model1_sort =$model1->sort;
        $model->sort=$model1_sort;
        $model->save(false);
        $model1->sort=$model_sort;
        $model1->save(false);

        $result['status'] = 1;
        $result['message'] = '设置成功';
        return $this->renderJson($result);
    }

    public function actionGetSon()
    {

        $area = Yii::$app->request->post('cate_id', 0);
        if ($area == 0) {
            $result['message'] = '缺失ID';
            $result['code'] = 0;
            return $this->renderJson($result);
        }
        $list = Category::getSon($area);
        if (empty($list)) {
            $result['message'] = '暂无信息';
            $result['code'] = 0;
            return $this->renderJson($result);
        }
        foreach ($list as $v) {
            $result['data'][] = [
                'sc_id' => $v->cate_id,
                'school_title' => $v->cate_title,
            ];
        }
        $result['message'] = '获取成功';
        $result['code'] = 1;
        return $this->renderJson($result);
    }
}