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
namespace common\action;

use common\models\Config;
use common\models\Error;
use yii\caching\DummyCache;
use yii\helpers\VarDumper;
use Yii;

/**
 * @property integer getMessage
 * @property string getLine
 * @property integer getTrace
 * @property string getCode
 * @property string getTraceAsString
 * @property integer getFile
 * @property integer getPrevious
 */
class ErrorAction
{

    public static function setError($code = '0', $class = '', $action = '', $line = '', $message = '')
    {

        if (!Yii::$app->params['errorReport'] || YII_DEBUG) {
            return true;
        }
        $url = Yii::$app->request->hostInfo.Yii::$app->request->getUrl();
        $model = Error::findOne(['class' => $class, 'action' => $action, 'message' => $message, 'url' =>$url]);
        if (empty($model)) {
            $model = new Error();
            $model->code = $code;
            $model->class = $class;
            $model->action = $action;
            $model->line = $line;
            $model->message = $message;
            $model->url = $url;
            $model->save(false);
        } else {
            Error::updateAllCounters(['total' => 1], ['class' => $class, 'action' => $action, 'message' => $message, 'url' =>$url]);
            if (!$model->is_mail) {
                if ($model->total >= 2) {
                    $mail = Yii::$app->mailer->compose();
                    $mail->setTo(Yii::$app->params['errorEmail'] ? Yii::$app->params['errorEmail'] : 'xww@shuwon.com');
                    $mail->setSubject(Config::findOne(['config_key' => 'web_site_title'])->config_value . "响应错误报告");
                    //$mail->setTextBody('zheshisha ');   //发布纯文字文本
                    $mail->setHtmlBody("Class:{$class},<br>Actions:{$action},<br>行号：{$line},<br>错误信息：{$message},<br>地址：{$url}");
                    if (@$mail->send()) {
                        //Error::updateAllCounters(['total'=>-10],['class'=>$class,'action'=>$action,'message'=>$message]);
                        $model->is_mail = 1;
                        $model->save(false);
                    }
                }
            }
        }

    }


}