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
class JoinUs extends Common {

    public static function tableName() {
        return 'tbl_news';
    }

    public function attributeLabels() {
        return [
    	    'news_id' => '新闻id',
		    'news_title' => '标题',
		    'news_abs' => '描述',
		    'news_face' => '封面(400*225px)',
		    'news_filed' => '新闻类别',
            'news_p_cate' => '一级分类',
            'news_cate' => '二级分类',
		    'news_content' => '内容',
		    'news_click' => '访问量',
		    'news_type' => '类型',
		    'recommend' => '首页推荐',
		    'created_at' => '添加时间',
		    'updated_at' => '更新时间',
		    'enabled' => '状态',
		    'sort' => '排序',
		    'user_id' => '用户ID',
	        ];
    }

    public function rules() {
        return [
             [['news_title','news_abs','news_filed','news_content','sort','news_face','recommend','news_click','news_cate','news_p_cate'], 'trim'],
             [['news_title','news_content'], 'required'],
             [['enabled','news_filed','recommend','news_click'], 'number'],
             ['news_type', 'string', 'length' => [1, 50]],
             ['news_title', 'string', 'length' => [1, 255]],['news_abs', 'string', 'length' => [1, 255]], ['news_filed', 'string', 'length' => [1, 255]],['news_face', 'string', 'length' => [1, 255]], 
             ['created_at', 'default','value'=>0], ['updated_at', 'default','value'=>0], ['enabled', 'default','value'=>1],['recommend', 'default','value'=>2], ['sort', 'default','value'=>0], ['user_id', 'default','value'=>0], ['news_click', 'default','value'=>0],
        ];
    }


    public function getCategory(){
        return $this->hasOne(Category::className(),['cate_id'=>'news_cate']);
    }
    public function getPcategory(){
        return $this->hasOne(Category::className(),['cate_id'=>'news_p_cate']);
    }

}

