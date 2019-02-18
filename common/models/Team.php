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
class Team extends Common {

    public static function tableName() {
        return 'tbl_img';
    }

    public function attributeLabels() {
        return [
    	    'img_id' => '',
            'img_title' => '名称',
            'img_subtitle' => '简介',
		    'img_face' => '图片(120*150)',
		    'img_type' => '类型',
		    'img_filed' => '简介',
		    'img_content' => '详细',
		    'created_at' => '添加时间',
		    'updated_at' => '更新时间',
		    'enabled' => '状态',
		    'sort' => '排序',
		    'user_id' => '用户ID',
	        ];
    }

    public function rules() {
        return [
             [['img_title','img_subtitle','img_face','sort','img_type','img_filed'], 'trim'],
             [['img_title','img_face','img_filed','img_filed'], 'required'],
             
             [['enabled'], 'number'],
             ['img_filed', 'string', 'length' => [1, 255]],
             ['img_title', 'string', 'length' => [1, 255]],['img_face', 'string', 'length' => [1, 255]],['img_type', 'string', 'length' => [1, 20]],
             ['created_at', 'default','value'=>0], ['updated_at', 'default','value'=>0], ['enabled', 'default','value'=>1], ['sort', 'default','value'=>0], ['user_id', 'default','value'=>0], 
        ];
    }


}

