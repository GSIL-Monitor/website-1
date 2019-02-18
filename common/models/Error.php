<?php
//                              _(\_/)
//                             ,((((^`\         //+--------------------------------------------------------------
//                            ((((  (6 \        //|Copyright (c) 2017 http://www.shuwon.com All rights reserved.
//                          ,((((( ,    \       //+--------------------------------------------------------------
//      ,,,_              ,(((((  /"._  ,`,     //|Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
//     ((((\\ ,...       ,((((   /    `-.-'     //+--------------------------------------------------------------
//     )))  ;'    `"'"'""((((   (               //|Author: xww < xww@wyw1.cn >
//    (((  /            (((      \              //+--------------------------------------------------------------
//     )) |                      |
//    ((  |        .       '     |
//    ))  \     _ '      `t   ,.')
//    (   |   y;- -,-""'"-.\   \/
//    )   / ./  ) /         `\  \
//       |./   ( (           / /'                __     __
//       ||     \\          //'|                /  \~~~/  \
//       ||      \\       _//'||          ,----(     ..    )
//       ||       ))     |_/  ||         /      \__     __/
//       \_\     |_/          ||       /|         (\  |(
//       `'"                  \_\     ^ \   /___\  /\ |
//                            `'"        |__|   |__|-"
namespace common\models;

use Yii;
use yii\db\ActiveRecord;
/**
 * ban模型。
 * @author 制作人
 * @since 1.0
 */
class Error extends ActiveRecord {

    public static function tableName() {
        return 'tbl_error';
    }

    public function attributeLabels() {
        return [
    	   'id'=>'',
    	   'code'=>'',
    	   'class'=>'',
    	   'action'=>'',
    	   'line'=>'',
    	   'message'=>'',
    	   'url'=>'',
    	   'total'=>'',
		    'created_at' => '添加时间',
		    'updated_at' => '更新时间',
	        ];
    }

    public function rules() {
        return [
             [['code','file','line','message','total','action'], 'trim'],
             ['created_at', 'default','value'=>0], ['updated_at', 'default','value'=>0]
        ];
    }

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->created_at = time();
                $this->updated_at = time();
            }else{
                $this->updated_at = time();
            }
            return true;
        }
        return false;
    }

}

