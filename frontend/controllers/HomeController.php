<?php
/**
 * @link http://www.shuwon.com/
 * @copyright Copyright (c) 2016 成都蜀美网络技术有限公司
 * @license http://www.shuwon.com/
 */
namespace frontend\controllers;
use common\models\Img;
use common\models\News;
use common\models\Single;
use Yii;


/**
 * 需控制器。
 * @author 制作人
 * @since 1.0
 */
class HomeController extends CommonController {

    public function actionIndex(){
        dump(Random());
    }
}