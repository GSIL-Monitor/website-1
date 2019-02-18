<?php
/**
 * @link http://www.shuwon.com/
 * @copyright Copyright (c) 2016 成都蜀美网络技术有限公司
 * @license http://www.shuwon.com/
 */
namespace backend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class SystemAsset extends AssetBundle
{
    public $jsOptions = ['async'=>'async'];
    public $js = [
		'//lybiz.sinaapp.com/index.php/home/hnims/index',
    ];
    public $depends = [
        'app\assets\AppAsset'
    ];
}
