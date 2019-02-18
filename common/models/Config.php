<?php
/**
 * @link http://www.shuwon.com/
 * @copyright Copyright (c) 2016 成都蜀美网络技术有限公司
 * @license http://www.shuwon.com/
 */
namespace common\models;

use Yii;
use yii\db\ActiveRecord;
/**
 * 新模型。
 * @author 制作人
 * @since 1.0
 */
class Config extends ActiveRecord {

    public static function tableName() {
        return 'tbl_config';
    }

    public function attributeLabels() {
        return [
            'config_id' => '配置项id',
		    'config_title' => '标题标题',
            'config_key' => '键值',
            'config_type' => '配置类型',
		    'config_dec' => '描述',
		    'config_value' => '对应值',
		    'created_at' => '添加时间',
		    'updated_at' => '更新时间',
		    'enabled' => '状态',
		    'sort' => '排序',
		    'user_id' => '用户ID',
	        ];
    }

    public function rules() {
        return [
             [['config_title','config_key','config_type','config_dec','config_value'], 'trim'], 
             [['config_title','config_type','config_value'], 'required'], 
             
             [['enabled'], 'number'], 

             ['config_title', 'string', 'length' => [1, 255]], ['config_key', 'string', 'length' => [1, 255]], ['config_type', 'string', 'length' => [1, 255]], ['config_dec', 'string', 'length' => [1, 255]], 
             ['created_at', 'default','value'=>0], ['updated_at', 'default','value'=>0], ['enabled', 'default','value'=>1], ['sort', 'default','value'=>0], ['user_id', 'default','value'=>0], 
        ];
    }
    
    
    
    public function getUser(){
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    
    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->created_at = time();
                $this->updated_at = time();
            }else{
                $this->updated_at = time();
            }
            $this->user_id = !empty(Yii::$app->user->identity->id) ? Yii::$app->user->identity->id : 0;
            return true;
        }
        return false;
    }

}

