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
 * ban模型。
 * @author 制作人
 * @since 1.0
 */
class Banner extends ActiveRecord {

    public static function tableName() {
        return 'tbl_img';
    }

    public function attributeLabels() {
        return [
    	    'img_id' => '',
		    'img_subtitle' => '显示标题',
		    'img_title' => '名称',
		    'img_face' => '图片(1920*480)',
		    'img_type' => '类型',
		    'created_at' => '添加时间',
		    'updated_at' => '更新时间',
		    'enabled' => '状态',
		    'sort' => '排序',
		    'user_id' => '用户ID',
	        ];
    }

    public function rules() {
        return [
             [['img_title','img_subtitle','img_face','sort','img_type','img_filed','img_content'], 'trim'],
             [['img_title','img_face','img_type'], 'required'],
             
             [['enabled'], 'number'],
             
             ['img_title', 'string', 'length' => [1, 255]],['img_face', 'string', 'length' => [1, 255]],['img_type', 'string', 'length' => [1, 20]],
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

