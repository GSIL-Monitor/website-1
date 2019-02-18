<?php

namespace backend\models;

use common\models\Common;
use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "tbl_menu".
 *
 * @property integer $id
 * @property string $name
 * @property string $module
 * @property string $controller
 * @property string $function
 * @property string $parameter
 * @property string $description
 * @property integer $is_display
 * @property integer $type
 * @property integer $pid
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $icon
 * @property integer $is_open
 * @property integer $orders
 */
class Menu extends Common
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['is_display', 'type', 'pid', 'created_at', 'updated_at', 'is_open', 'orders'], 'integer'],
            [['name', 'module', 'parameter'], 'string', 'max' => 50],
            [['controller', 'function', 'icon'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 250],
            [['is_open'], 'default', 'value' => 0],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'module' => 'Module',
            'controller' => 'Controller',
            'function' => 'Function',
            'parameter' => 'Parameter',
            'description' => 'Description',
            'is_display' => 'Is Display',
            'type' => 'Type',
            'pid' => 'Pid',
            'created_at' => 'Create Time',
            'updated_at' => 'Update Time',
            'icon' => 'Icon',
            'is_open' => 'Is Open',
            'orders' => 'Orders',
        ];
    }

    public static function getSon($pid){
        return self::find()->where(['pid'=>$pid])->orderBy(['sort'=>SORT_ASC,'id'=>SORT_ASC])->all();
    }
    public static function getParent(){
        return self::find()->where(['pid'=>0])->orderBy(['sort'=>SORT_ASC,'id'=>SORT_ASC])->all();
    }
    public static function menulist($menu,$id=0,$level=0){
        static $menus = array();
        foreach ($menu as $value) {
            if ($value['pid']==$id) {
                $value['level'] = $level+1;
                if($level == 0)
                {
                    $value['str'] = str_repeat('',$value['level']);
                }
                elseif($level == 2)
                {
                    $value['str'] = '&emsp;&emsp;&emsp;&emsp;'.'└ ';
                }
                elseif($level == 3)
                {
                    $value['str'] = '&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;'.'└ ';
                }
                else
                {
                    $value['str'] = '&emsp;&emsp;'.'└ ';
                }
                $menus[] = $value;
                self::menulist($menu,$value['id'],$value['level']);
            }
        }
        return $menus;
    }

    public static function setSecond($pid){
        $html = '<ul class="nav nav-second-level">';
        foreach (self::getSon($pid) as $k=>$v){
            if (empty($third = self::getSon($v->id))){
                $html.='<li><a class="J_menuItem" href="'.Url::toRoute([$v->controller.'/'.$v->controller]).'">'.$v->name.'</a></li>';
            }else{
                $html.=self::setThird($third,$v->name);
            }
        }
        $html.='</ul>';
        return $html;
    }
    public static function setThird($third,$name){
        $html = '<li><a href="#">'.$name.' <span class="fa arrow"></span></a>
                        <ul class="nav nav-third-level">';
        foreach ($third as $k=>$v){
            $html.='<li><a class="J_menuItem" href="'.$v->controller.'/'.$v->function.'?'.$v->parameter.'">'.$v->name.'</a></li>';
        }
        $html.=' </ul></li>';
        return $html;
    }
}
