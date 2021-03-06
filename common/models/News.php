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
class News extends Common {

    public static function tableName() {
        return 'tbl_news';
    }

    public function attributeLabels() {
        return [
    	    'news_id' => '新闻id',
		    'news_title' => '标题',
		    'news_author' => '来源',
		    'news_abs' => '描述',
		    'news_face' => '封面(600*440px)',
		    'news_bg' => '首页图片(400*225px)',
		    'news_filed' => '关联品牌',
            'news_type' => '新闻分类',
            'news_p_cate' => '新闻类别',
            'news_cate' => '二级类别',
            'news_content' => '内容',
            'news_click' => '访问量',
            'time' => '自定义时间',
		    'recommend' => '首页推荐',
		    'created_at' => '添加时间',
		    'updated_at' => '更新时间',
		    'enabled' => '审核',
		    'sort' => '排序',
		    'user_id' => '用户ID',
	        ];
    }

    public function rules() {
        return [
             [['news_title','news_abs','news_filed','news_bg','news_click','news_content','sort','news_face','recommend','news_type','news_cate','news_author','time','news_p_cate'], 'trim'],
             [['news_title','news_type','news_p_cate','news_author'], 'required'],
             
             [['enabled','news_filed','recommend','news_cate'], 'number'],

             ['news_type', 'string', 'length' => [1, 100]],
             ['news_title', 'string', 'length' => [1, 255]],['news_abs', 'string', 'length' => [1, 255]], ['news_filed', 'string', 'length' => [1, 255]],['news_face', 'string', 'length' => [1, 255]], 
             ['created_at', 'default','value'=>0], ['updated_at', 'default','value'=>0], ['enabled', 'default','value'=>1],['recommend', 'default','value'=>2], ['sort', 'default','value'=>0], ['user_id', 'default','value'=>0], 
        ];
    }

}

