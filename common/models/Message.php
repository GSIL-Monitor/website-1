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

use yii\db\ActiveRecord;

class Message extends ActiveRecord{
    public static function tableName() {
        return 'tbl_message';
    }
    public function attributeLabels() {
        return [
           'id'=>'',
           'userName'=>'学生姓名',
           'sex'=>'性别',
           'nation'=>'民族',
            'class'=>'班级',
            'birthday'=>'出生日期',
            'nationality'=>'国籍',
            'code'=>'身份证号码',
            'place'=>'工作单位',
            'position'=>'职位',
            'address'=>'详细地址',
            'name'=>'联系人姓名',
            'relationship'=>'与学生关系',
            'mobile'=>'联系电话',
            'email'=>'邮箱',
            'weixin'=>'微信号',
            'type'=>'分类',
            'school_type'=>'入校方式',
            'remarks'=>'备注',
           'enabled'=>'是否显示',
           'create_at'=>'创建时间',
           'update_at'=>'更新时间',
        ];
    }
}