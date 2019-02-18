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

class MenuController extends CommonController
{

    public function init()
    {
        parent::init();
        $this->models = Menu::className();            // 设置改站点默认模型 用于获取数据
    }

    /**
     * 主页面
     */
    public function actionIndex()
    {
        return $this->render('index', [
            'model' => $this->findModel(),
        ]);
    }

    /**
     * 编辑/新增
     */

    public function actionEdit()
    {
        $id = Yii::$app->request->get('id');        // 获取编辑id  不存在则为新增状态
        $p_id = Yii::$app->request->get('parent_id', '');
        $model = $this->findModel($id);                // 获取模型
        if (Yii::$app->request->getIsPost()) {
            $result['status'] = 1;
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                $result['message'] = '保存成功';
                $result['url'] = Url::toRoute(['menu/index', 'type' => Yii::$app->request->get('type')]);
            }
            $errors = $model->getFirstErrors();
            if ($errors) {
                $result['status'] = 0;
                $result['message'] = current($errors);
            }
            return $this->renderJson($result);
        } else {
            if ($model->isNewRecord && $p_id!=''){
                $model->pid = $p_id ?? '0';
            }
            return $this->render('edit', [
                'model' => $model,
            ]);
        }
    }

    public function actionList()
    {
        $query = Menu::find();
        $query->andWhere(['pid' => 0])->orderBy(['sort' => SORT_ASC, 'id' => SORT_ASC]);
        $provider = $query->all();
        return $this->renderPartial('list', ['provider' => $provider]);
    }

    public function actionDel($id)
    {
        $result = array();
        if ($this->findModel($id)->delete()) {
            $result['status'] = 1;
            $result['message'] = '删除成功';
        } else {
            $result['status'] = 0;
            $result['message'] = '删除失败';
        }
        return $this->renderJson($result);
    }


    public static function setSon($id)
    {
        $html = '';
        foreach (Menu::getSon($id) as $k => $v) {

            $html .= '<ol class="dd-list">';
            $html .= ' <li class="dd-item dd-nodrag" data-id="' . $v->id . '" style="max-width: 95%">';
            $html .= '<div class="dd-handle">
                    <p class="operating pull-right">';
            $html .= ' <a class="btn-sm btn-info" href="' . Url::toRoute(['menu/edit','parent_id' => $v->id]). '">
                        <i class="fa fa-plus"></i> 添加
                     </a>';
            $html .= '<a class="btn-sm btn-info" href="' . Url::toRoute(['menu/edit', 'id' => $v->id]) . '">
                       <i class="fa fa-edit"></i> 编辑
                    </a>';
            $html .= '<a class="btn-sm btn-danger" href="javascript:void(0);" onclick="del(' . $v->id . '">
                       <i class="fa fa-trash-o"></i> 删除
                    </a>
                    </p>
                    <span class="label label-info"><i class="fa fa-cog"></i></span>
                    ';
            $html .= $v->name;
            $html .= '</div>';

            $html .= self::setSon($v->id);

            $html .= '</ol>';
        }
        return $html;
    }



    public static function GetMenu()
    {
        $menu = Menu::find()->asArray()->all();
        $data = [];
        foreach (Menu::menulist($menu) as $k => $v) {
            $data[$v['id']] = $v['str'] . $v['name'];
        }
        return $data;
    }

    public function actionMenu()
    {
        $menu = Menu::find()->asArray()->all();
        $result['code'] = 1;
        $result['data'] = Menu::menulist($menu);
        return $this->renderJson($result);
    }


}