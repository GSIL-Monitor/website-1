<?php
/**
 * @link http://www.shuwon.com/
 * @copyright Copyright (c) 2016 成都蜀美网络技术有限公司
 * @license http://www.shuwon.com/
 */

namespace backend\controllers;

use common\models\JoinUs;
use Yii;
use yii\helpers\VarDumper;
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
class JoinUsController extends CommonController
{

    public function init()
    {
        parent::init();
        $this->models =JoinUs::className();            // 设置改站点默认模型 用于获取数据
    }

    /**
     * 主页面
     */
    public function actionIndex()
    {
        return $this->render('index', [
            'model' => $this->findModel(),
        ]);
    }

    /**
     * 编辑/新增
     */

    public function actionEdit()
    {
        $id = Yii::$app->request->get('id');        // 获取编辑id  不存在则为新增状态
        $model = $this->findModel($id);                // 获取模型

        if (Yii::$app->request->getIsPost()) {
            $result['status'] = 1;
            $model->news_type = 'join-us';
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                $result['message'] = '保存成功';
                $result['url'] = Url::toRoute(['join-us/index']);
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
        $query = JoinUs::find();
        $query->where(['news_type' => 'join-us']);
        $query->andFilterWhere(["like", "news_title", Yii::$app->request->get("news_title")]);
        $query->andFilterWhere(["news_filed" => Yii::$app->request->get("news_filed")]);
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
}