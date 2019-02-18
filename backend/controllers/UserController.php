<?php
/**
 * @link http://www.shuwon.com/
 * @copyright Copyright (c) 2016 成都蜀美网络技术有限公司
 * @license http://www.shuwon.com/
 */

namespace backend\controllers;

use backend\models\Menu;
use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use backend\models\UserForm;
use backend\models\RoleForm;

/**
 * 用户管理控制器。
 * @author 制作人
 * @since 1.0
 */
class UserController extends CommonController
{

    public function actionIndex()
    {
        $auth = Yii::$app->authManager;
        $listRoles = ArrayHelper::getColumn($auth->getRoles(), 'name');
        return $this->render('index', ['model' => new UserForm(), 'listRoles' => $listRoles]);
    }

    public function actionEdit()
    {
        $auth = Yii::$app->authManager;
        $data = Yii::$app->request->post('UserForm');
        $result = array();
        $oldPassword; //更改用户时如果不改密码，保存旧密码
        if (is_numeric($data['id']) && $data['id'] > 0) {
            $user = UserForm::findOne($data['id']);
            if (!$user) {
                $result['status'] = 0;
                $result['message'] = '未找到该记录';
            } else {
                $oldPassword = $user->password;
            }
        } else {
            $user = new UserForm();
        }
        if ($user->load(Yii::$app->request->post())) {
            if (!$user->isNewRecord && $user->password != '******') {
                $oldPassword = Yii::$app->security->generatePasswordHash($user->password);
            }
            if ($user->save()) {
                if (isset($oldPassword)) {
                    //重置密码
                    UserForm::updateAll(['password' => $oldPassword], 'id=:id', [':id' => $user->id]);
                }
                //分配权限
                $auth->revokeAll($user->id); //删除所有权限
                foreach ($user->roles as $rolename) {
                    if ($role = $auth->getRole($rolename)) {
                        $auth->assign($role, $user->id);
                    }
                }
                $result['status'] = 1;
                $result['message'] = '保存成功';
            }
        }
        $errors = $user->getFirstErrors();
        if ($errors) {
            $result['status'] = 0;
            $result['message'] = current($errors);
        }
        return $this->renderJson($result);
    }

    public function actionList()
    {
        $auth = Yii::$app->authManager;
        $model = UserForm::find()->all();
        return $this->renderPartial('list', ['model' => $model]);
    }

    public function actionDel($id)
    {
        $result = array();
        $model = UserForm::findOne($id);
        $model->delete();
        $result['status'] = 1;
        $result['message'] = '删除成功';
        return $this->renderJson($result);
    }

    public function getAllMenu($pid = 0)
    {
        $menu = [];
        foreach (Menu::getSon($pid) as $k => $v) {
            if (empty($v->controller) || empty($v->funcation)) {
                $menu[] = ['name' => $v->module, 'description' => $v->name, 'child' => $this->getAllMenu($v->id)];
            } else {
                $menu[] = ['name' => $v->controller . '/' . $v->funcation, 'description' => $v->name, 'child' => $this->getAllMenu($v->id)];
            }
        }
        return $menu;
    }

    public function actionRole()
    {
        $auth = Yii::$app->authManager;


        /*$permissions = [
            ['name' => 'Info', 'description' => '基本信息', 'child' => []],
            ['name' => 'Seo', 'description' => 'SEO管理', 'child' => []],
            ['name' => 'Banner', 'description' => '首页banner管理', 'child' => []],
            ['name' => 'Sinbanner', 'description' => '内页banner管理', 'child' => []],
            ['name' => 'About', 'description' => '关于我们', 'child' => []],
            ['name' => 'News', 'description' => '新闻资讯', 'child' => []],
            ['name' => 'Fzdt', 'description' => '分站动态', 'child' => []],
            ['name' => 'Ywpd', 'description' => '业务频道', 'child' => []],
            ['name' => 'Jcsl', 'description' => '检测实力', 'child' => []],
            ['name' => 'Rcsl', 'description' => '人才实力', 'child' => []],
            ['name' => 'Hdjl', 'description' => '互动交流', 'child' => []],
            ['name' => 'Ztzl', 'description' => '专题专栏', 'child' => []],
            ['name' => 'Kfzx', 'description' => '客服中心', 'child' => []],
            ['name' => 'Lxwm', 'description' => '联系我们', 'child' => []],
            ['name' => 'User', 'description' => '权限管理', 'child' => []],
            ['name' => 'Information', 'description' => '信息公开', 'child' => [
                ['name' => 'single/message', 'description' => '政府信息公开外联'],
                ['name' => 'messagepost', 'description' => '信息公开年报'],
                ['name' => 'news/9', 'description' => '政策法规'],
                ['name' => 'news/8', 'description' => '人事任免'],
                ['name' => 'news/7', 'description' => '财政预结算'],
                ['name' => 'news/6', 'description' => '建设规划'],
                ['name' => 'news/5', 'description' => '重大项目'],
                ['name' => 'news/4', 'description' => '地矿统计'],
                ['name' => 'news/3', 'description' => '安全生产'],
                ['name' => 'news/2', 'description' => '全面推荐“五公开”'],

            ]],
        ];*/
        //dump($this->getAllMenu());exit;
        return $this->render('role', ['model' => new RoleForm(), 'permissions' => $this->getAllMenu()]);
    }

    public function actionRolelist()
    {
        $model = \Yii::$app->authManager->getRoles();
        return $this->renderPartial('rolelist', ['model' => $model]);
    }

    public function actionRoleedit()
    {
        $auth = \Yii::$app->authManager;
        $model = new RoleForm();
        $result = array();
        if ($model->load(Yii::$app->request->post())) {
            $role = $auth->getRole($model->name);
            if (!$role) {
                $role = $auth->createRole($model->name);
                $auth->add($role);
            }
            //分配权限
            $oldPermissions = array();
            if ($auth->getPermissionsByRole($role->name)) {
                $oldPermissions = ArrayHelper::getColumn($auth->getPermissionsByRole($role->name), 'name');
            }
            is_array($model->permissions) ? $newPermissions = $model->permissions : $newPermissions = array();
            //计算交集
            $intersection = array_intersect($newPermissions, $oldPermissions);
            //需要增加的权限
            $newPermissions = array_diff($newPermissions, $intersection);
            //需要删除的权限
            $oldPermissions = array_diff($oldPermissions, $intersection);
            foreach ($newPermissions as $new) {
                $auth->addChild($role, $auth->getPermission($new));
            }
            foreach ($oldPermissions as $old) {
                $auth->removeChild($role, $auth->getPermission($old));
            }
            $result['status'] = 1;
            $result['message'] = '保存成功';
        }
        $errors = $model->getFirstErrors();
        if ($errors) {
            $result['status'] = 0;
            $result['message'] = current($errors);
        }
        return $this->renderJson($result);
    }

    public function actionGetpermissionsbyrole($name)
    {
        $result = array();
        $auth = \Yii::$app->authManager;
        $permissions = $auth->getPermissionsByRole($name);
        if ($permissions) {
            foreach ($permissions as $p) {
                $result[] = $p->name;
            }
        }
        return $this->renderJson($result);
    }

    public function actionRoledel($name)
    {
        $result = array();
        $auth = Yii::$app->authManager;
        $role = $auth->getRole($name);
        if ($role) {
            $auth->remove($role);
        }
        $result['status'] = 1;
        $result['message'] = '删除成功';
        return $this->renderJson($result);
    }

    private function getChild($item)
    {
        $auth = Yii::$app->authManager;
        $item = (array)$item;
        if ($childs = $auth->getChildren($item['name'])) {
            foreach ($childs as $child) {
                $item['child'][] = $this->getChild($child);
            }
            return $item;
        } else {
            return $item;
        }
    }

    public static function getRole($permission)
    {
        $html = '';
        foreach ($permission as $k => $v) {
            $html.=
                '<div class="form-group">
                     <div class="col-md-3">
                          <label class="checkbox-inline">';
            $html.='<input type="checkbox" name="RoleForm[permissions][]" value="'.$v['name'].'">'.$v['description'];
            $html.='">';
            $html.='      </label>
                    </div>
                 <div class="col-md-9">';
            $html.='';
            $html.='';
            $html.='';
            $html.='';
            $html.='';
            $html.='';
            $html.='';
        }
    }
}
