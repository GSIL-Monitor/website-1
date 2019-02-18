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
class Hr extends Common {

    public static function tableName() {
        return 'tbl_hr';
    }

    public function attributeLabels() {
        return [
    	    'hr_id' => '新闻id',
		    'hr_name' => '职位名称',
		    'num' => '招聘人数',
		    'duty' => '岗位要求',
		    'requirement' => '职位描述',
		    'hr_type' => '类型',
            'time'=>'自定义时间',
		    'recommend' => '首页推荐',
		    'created_at' => '添加时间',
		    'updated_at' => '更新时间',
		    'enabled' => '审核',
		    'sort' => '排序',
            'user_id' => '用户ID',
            'lang' => '语言版本'
	        ];
    }

    public function rules() {
        return [
             [['hr_name','num','duty','requirement','sort','hr_type'], 'trim'],
             [['hr_name'], 'required'],
             
             [['enabled','recommend'], 'number'],
            [['time'], 'filter', 'filter' => 'strtotime'],
             ['hr_name', 'string', 'length' => [1, 255]],
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

