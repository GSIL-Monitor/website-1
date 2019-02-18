<?php
/**
 * @link http://www.shuwon.com/
 * @copyright Copyright (c) 2016 成都蜀美网络技术有限公司
 * @license http://www.shuwon.com/
 */

namespace common\models;

use backend\models\User;
use Yii;
use yii\db\ActiveRecord;

/**
 * 活动模型。
 * @author 制作人
 * @since 1.0
 */
class Common extends ActiveRecord
{
    public function getUser(){
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->created_at = time();
                $this->updated_at = time();
               $lang = Yii::$app->request->get('lang');
                $this->lang = in_array($lang,Yii::$app->params['lang'])?$lang:'cn';
            }else{
                $this->updated_at = time();
            }
            $this->user_id = !empty(Yii::$app->user->identity->id) ? Yii::$app->user->identity->id : 0;
            return true;
        }
        return false;
    }
}