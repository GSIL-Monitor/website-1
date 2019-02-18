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
use common\models\Single;
/**
 * 管理控制器。
 * @author 制作人
 * @since 1.0
 */
class SingleController extends CommonController {

    /**
     * 编辑
     */
    public function actionEdit() {
    	if(Yii::$app->request->getIsPost()){
	        $data = Yii::$app->request->post('Single');
	        $result = array();

	        if (is_numeric($data['single_id']) && $data['single_id'] > 0) {
	            $model = Single::findOne($data['single_id']);
	            if (!$model) {
	                $result['status'] = 0;
	                $result['message'] = '未找到该记录';
	            }
	        }else{
	            $model = new Single();
            }
	        if ($model->load(Yii::$app->request->post())) {
	            if ($model->save()) {
	                $result['status'] = 1;
	                $result['message'] = '保存成功';
	                $result['url'] = Url::toRoute(['single/edit','type' => $model->type]);
	            }
	        }
	        $errors = $model->getFirstErrors();
	        if ($errors) {
	            $result['status'] = 0;
	            $result['message'] = current($errors);
	        }
	        return $this->renderJson($result);
    	}else{
			$type = Yii::$app->request->get('type');
			$model = Single::find()->where(['type' => $type])->One();
			if (empty($model)){
                $model = new Single();
                $model->type = $type;
			}
    		return $this->render('edit', [
    				'model' => $model,
    				]);
    	}
    }
}

