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
class Seo extends ActiveRecord {

    public static function tableName() {
        return 'tbl_seo';
    }

    public function attributeLabels() {
        return [
    	    'seo_id' => 'id',
		    'title' => '栏目名称',
            'subtitle' => '栏目标题',
            'subtitle_en' => '栏目标题',
            'banner_face' => 'Banner封面',
            'face' => 'banner(1920x700)',
            'face_en' => 'banner(1920x700)',
		    'keywords' => '关键字',
		    'description' => '描述',
		    'description_en' => '描述',
		    'created_at' => '添加时间',
		    'updated_at' => '更新时间',
		    'enabled' => '审核',
		    'sort' => '排序',
		    'user_id' => '用户ID',
	        ];
    }

    public function rules() {
        return [
             [['seo_id','subtitle','description_en','face_en','subtitle_en','face','title','keywords','description','banner_face'], 'trim'],
             [['title'], 'required'],
             
             [['enabled',], 'number'], 
             
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

