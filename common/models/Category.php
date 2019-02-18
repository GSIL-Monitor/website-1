<?php

namespace common\models;

use Yii;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "tbl_category".
 *
 * @property integer $cate_id
 * @property string $cate_title
 * @property integer $parent_id
 * @property string $cate_type
 * @property string $cate_content
 * @property integer $enabled
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $lang
 * @property integer $user_id
 */
class Category extends \common\models\Common
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cate_title'], 'required'],
            [['cate_type', 'sort'], 'trim'],
            [['cate_id', 'parent_id', 'enabled', 'created_at', 'updated_at', 'user_id', 'sort'], 'integer'],
            [['cate_content'], 'string'],
            [['thumb'], 'string'],
            [['cate_title', 'cate_type', 'lang'], 'string', 'max' => 255],
            [['lang'], 'string', 'max' => 50],
            ['lang', 'default', 'value' => 'cn'],
            ['created_at', 'default', 'value' => 0],
            ['updated_at', 'default', 'value' => 0],
            ['enabled', 'default', 'value' => 1],
            ['user_id', 'default', 'value' => 0],
            ['parent_id', 'default', 'value' => 0],
            ['recommend', 'default', 'value' => 0],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cate_id' => '分类ID',
            'cate_title' => '分类名',
            'parent_id' => '父级ID',
            'cate_type' => '分类',
            'thumb' => '图片',
            'cate_content' => '详情',
            'enabled' => '是否启用',
            'recommend' => '是否启用',
            'created_at' => '创建时间',
            'updated_at' => '更行时间',
            'lang' => '语言',
            'sort' => '排序',
            'user_id' => '用户ID',
        ];
    }

    public static function getSon($parent)
    {
        if ($parent) {
            $query = self::find()->where(['enabled' => 1, 'parent_id' => $parent])->orderBy(['sort' => SORT_DESC, 'cate_id' => SORT_DESC])->all();
        } else {
            //$query = self::find()->where("`enabled`=1 AND `parent_id` <> 0")->all();
            $query = [];
        }
        return $query;
    }

    public static function getParent($type, $recommend = null, $auth = false)
    {
        $notIn = null;
        if ($auth) {
            if (!Yii::$app->user->can('Fzdt')) {
                $notIn = 14;
            }
        }
        return self::find()->where(['enabled' => 1, 'parent_id' => 0, 'cate_type' => $type])->andFilterWhere(['<>', 'cate_id', $notIn])->andFilterWhere(['recommend' => $recommend])->orderBy(['sort' => SORT_DESC, 'cate_id' => SORT_DESC])->all();
    }

    public static function getCateName($id)
    {
        return self::findOne($id)->cate_title;
    }

}
