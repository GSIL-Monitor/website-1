<?php
/**
 * @link http://www.shuwon.com/
 * @copyright Copyright (c) 2016 成都蜀美网络技术有限公司
 * @license http://www.shuwon.com/
 */

use yii\helpers\Url;

$get = Yii::$app->request->get();
$controller = Yii::$app->controller->id;
$action = Yii::$app->controller->action->id;
$route = Yii::$app->controller->module->requestedRoute;
$url = Yii::$app->request->url;
$type = $get['type'] ?? '';
//专题
?>
<?php foreach (\backend\models\Menu::getParent() as $k=>$v){
    if (Yii::$app->user->can($v->module)) break;
    if (empty($v->parameter)){
        $par = '';
    }else{
        $argv_ = explode(':',$v->parameter);
        $par = '?'.$argv_[0].'='.$argv_[1];
    }
?>
<li class="treeview">
    <a href="<?=(empty($v->controller) || empty($v->function))?'#':Url::toRoute([$v->controller.'/'.$v->function]).$par?>">
        <i class="fa <?=$v->icon?$v->icon : 'fa-circle-o'?>"></i>
        <span><?=$v->name?></span>
    </a>
    <?=\backend\controllers\MenuController::setMenu($v->id)?>
</li>
<?php }?>




    <li class="treeview <?php if ($controller == 'seo' || $controller == 'config') { ?>active<?php } ?>">
        <a href="#">
            <i class="fa fa-circle-o"></i>
            <span>网站设置</span>
        </a>
        <ul class="treeview-menu">
            <li style="display: none"
                <?php if ($controller == 'catebanner' && $route == 'catebanner/index'){ ?>class="active"<?php } ?>>
                <a href="<?= Url::toRoute('catebanner/index') ?>"><i class="fa fa-circle-o"></i>栏目banner管理</a>
            </li>
            <li <?php if ($controller == 'config' && $route == 'config/index'){ ?>class="active"<?php } ?>>
                <a href="<?= Url::toRoute('config/index') ?>"><i class="fa fa-caret-right"></i>基本信息</a>
            </li>
            <li <?php if ($controller == 'config' && $route == 'admin/profile'){ ?>class="active"<?php } ?>>
                <a href="<?= Url::toRoute('admin/profile') ?>"><i class="fa fa-caret-right"></i>修改密码</a>
            </li>
            <li <?php if ($controller == 'seo' && $route == 'seo/index'){ ?>class="active"<?php } ?>>
                <a href="<?= Url::toRoute('seo/index') ?>"><i class="fa fa-caret-right"></i>SEO管理</a>
            </li>
        </ul>
    </li>




    <li class="treeview <?php if ($controller == 'banner' || $controller == 'indexbanner') { ?>active<?php } ?>">
        <a href="#">
            <i class="fa fa-circle-o"></i>
            <span>Banner管理</span>
        </a>
        <ul class="treeview-menu">
            <?php if (Yii::$app->user->can('Banner')) { ?>
                <li <?php if ($route == 'indexbanner/index' || $route == 'indexbanner/edit'){ ?>class="active"<?php } ?>>
                    <a href="<?= Url::toRoute('indexbanner/index') ?>"><i class="fa fa-circle-o"></i> 首页banner列表</a>
                </li>
            <?php } ?>
            <?php if (Yii::$app->user->can('Sinbanner')) { ?>
                <li <?php if ($route == 'banner/index' || $route == 'banner/edit'){ ?>class="active"<?php } ?>>
                    <a href="<?= Url::toRoute('banner/index') ?>"><i class="fa fa-circle-o"></i> 内页banner列表</a>
                </li>
            <?php } ?>
        </ul>
    </li>



    <li style="" class="treeview <?php if ($controller == 'user' || $controller=='menu' || $controller=='rbac') { ?>active<?php } ?>">
        <a href="#">
            <i class="fa fa-circle-o"></i>
            <span>权限管理</span>
        </a>
        <ul class="treeview-menu">
            <li <?php if ($controller == 'menu' && Yii::$app->controller->action->id == 'index'){ ?>class="active"<?php } ?>>
                <a href="<?= Url::toRoute('menu/index') ?>"><i class="fa fa-circle-o"></i> 菜单列表</a>
            </li>
            <li <?php if ($controller == 'rbac' && Yii::$app->controller->action->id == 'index'){ ?>class="active"<?php } ?>>
                <a href="<?= Url::toRoute('rbac/permission-index') ?>"><i class="fa fa-circle-o"></i> 权限列表</a>
            </li>
            <li <?php if ($controller == 'user' && Yii::$app->controller->action->id == 'index'){ ?>class="active"<?php } ?>>
                <a href="<?= Url::toRoute('user/index') ?>"><i class="fa fa-circle-o"></i> 用户管理</a>
            </li>
            <li <?php if ($controller == 'user' && Yii::$app->controller->action->id == 'role'){ ?>class="active"<?php } ?>>
                <a href="<?= Url::toRoute('user/role') ?>"><i class="fa fa-circle-o"></i> 角色管理</a>
            </li>
            <li style="display: none" <?php if ($controller == 'error'){ ?>class="active"<?php } ?>>
                <a href="<?= Url::toRoute('error/index') ?>"><i class="fa fa-circle-o"></i> 错误报告</a>
            </li>
        </ul>
    </li>
