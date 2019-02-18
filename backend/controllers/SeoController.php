<?php
/**
 * @link http://www.shuwon.com/
 * @copyright Copyright (c) 2016 成都蜀美网络技术有限公司
 * @license http://www.shuwon.com/
 */

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\data\ActiveDataProvider;
use common\models\Seo;

/**
 * 新管理控制器。
 * @author 制作人
 * @since 1.0
 */
class SeoController extends CommonController
{

    public function actionIndex()
    {
        return $this->render('index', [
            'model' => new Seo(),
        ]);
    }

    public function actionAdd()
    {
        if (Yii::$app->request->getIsPost()) {
            $data = Yii::$app->request->post('Seo');
            $result = array();
            $model = new Seo();
            if ($model->load(Yii::$app->request->post())) {
                if ($model->save()) {
                    $result['status'] = 1;
                    $result['message'] = '保存成功';
                    $result['url'] = Url::toRoute('seo/index');
                }
            }
            $errors = $model->getFirstErrors();
            if ($errors) {
                $result['status'] = 0;
                $result['message'] = current($errors);
            }
            return $this->renderJson($result);
        } else {
            $model = new Seo();
            return $this->render('add', [
                'model' => $model,
            ]);
        }
    }

    public function actionEdit()
    {
        if (Yii::$app->request->getIsPost()) {
            $data = Yii::$app->request->post('Seo');
            $result = array();
            if (is_numeric($data['seo_id']) && $data['seo_id'] > 0) {
                $model = Seo::findOne($data['seo_id']);
                if (!$model) {
                    $result['status'] = 0;
                    $result['message'] = '未找到该记录';
                }
            }
            if ($model->load(Yii::$app->request->post())) {
                if ($model->save()) {
                    $result['status'] = 1;
                    $result['message'] = '保存成功';
                    $result['url'] = Url::toRoute('seo/index');
                }
            }
            $errors = $model->getFirstErrors();
            if ($errors) {
                $result['status'] = 0;
                $result['message'] = current($errors);
            }
            return $this->renderJson($result);
        } else {
            $id = Yii::$app->request->get('id');
            $model = Seo::findOne($id);
            return $this->render('edit', [
                'model' => $model,
            ]);
        }
    }

    public function actionList()
    {
        $query = Seo::find();
        $query->andWhere(['lang' => $this->lang]);
        $query->andFilterWhere(["like", "title", Yii::$app->request->get("title")]);
        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'sort' => SORT_DESC,
                    'seo_id' => SORT_DESC,
                ]
            ],
        ]);
        return $this->renderPartial('list', ['provider' => $provider]);
    }

    public function actionDel($id)
    {
        $result = array();
        $model = Seo::findOne($id);

        $model->delete();
        $result['status'] = 1;
        $result['message'] = '删除成功';
        return $this->renderJson($result);
    }
}

