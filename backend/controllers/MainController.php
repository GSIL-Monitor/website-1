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


namespace backend\controllers;

use \yii\helpers\Url;
use Yii;
use backend\models\Menu;
use yii\data\ActiveDataProvider;
use yii\helpers\VarDumper;

class MainController extends CommonController
{
    /**
     * 主页面
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}