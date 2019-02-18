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
 * 模型。
 * @author 制作人
 * @since 1.0
 */
class Single extends Common
{

    public static function tableName()
    {
        return 'tbl_single';
    }

    public function attributeLabels()
    {
        return [
            'single_id' => '单页',
            'single_title' => '标题',
            'single_subtitle' => '副标题',
            'brand_id' => '品牌',
            'single_abstract' => '展示标题',
            'single_face' => '图片',
            'single_content' => '内容',
            'type' => '类型',
            'created_at' => '添加时间',
            'updated_at' => '更新时间',
            'enabled' => '审核',
            'sort' => '排序',
            'user_id' => '用户ID',
        ];
    }

    public function rules()
    {
        return [
            [['single_title', 'single_content', 'single_face', 'single_abstract', 'sort', 'type', 'brand_id', 'single_subtitle'], 'trim'],
            [['enabled'], 'number'],
            [['single_title'], 'required'],
            ['single_subtitle', 'string', 'length' => [1, 100]],['type', 'string', 'length' => [1, 255]],
            ['single_title', 'string', 'length' => [1, 255]], ['single_face', 'string', 'length' => [1, 255]], ['single_abstract', 'string', 'length' => [1, 255]],
            ['created_at', 'default', 'value' => 0], ['updated_at', 'default', 'value' => 0], ['enabled', 'default', 'value' => 1], ['sort', 'default', 'value' => 0], ['user_id', 'default', 'value' => 0],
        ];
    }
}

